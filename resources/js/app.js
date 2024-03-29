require("./bootstrap");

import { createApp } from "vue";
import TileRowComponent from "./components/TileRowComponent.vue";
import { allWords, getWordOfTheDay } from "./src/words.js";
import KeyButton from "./components/KeyButton.vue";
import GameModal from "./components/GameModal";
import { v4 as uuidv4 } from "uuid";

var app = createApp({
    data() {
        return {
            guesses: [[], [], [], [], [], []],
            currentRow: 0,
            allowInput: true,
            message: "",
            modals: {
                helpActive: false,
                successActive: false,
                failedActive: false,
                statsActive: true,
            },

            stats: {
                played: 0,
                wins: 0,
                winPercentage: 0,
                currentStreak: 0,
                maxStreak: 0,
                guessDistribution: {
                    r1: 0,
                    r2: 0,
                    r3: 0,
                    r4: 0,
                    r5: 0,
                    r6: 0,
                },
                percentileRank: 0
            },

            dailyCorrectPercentage: 0,
            dailyAverageAttempts: 0,
            dailyDistribution: {
                r1: 0,
                r2: 0,
                r3: 0,
                r4: 0,
                r5: 0,
                r6: 0,
            },
            wiggleRow: null,
            wordOfTheDay: null,
        };
    },

    components: {
        tileRow: TileRowComponent,
        KeyButton,
        GameModal,
    },

    mounted() {
        this.wordOfTheDay = getWordOfTheDay();

        this.retrieve();
        this.fetchRemoteStats();

        window.addEventListener("keydown", (e) => {
            this.keyWasPressed(e.key);
        });

        this.getResultText();
    },

    methods: {
        keyWasPressed(key) {
            if (!this.allowInput) return;

            if (/^[a-zA-Z]$/.test(key)) {
                this.addTile(key);
            }
            if (key === "Backspace") {
                this.removeTile();
            }

            if (key === "Enter") {
                this.tryGuess();
            }
        },

        addTile(key) {
            if (!this.guessIsComplete()) {
                this.guesses[this.currentRow].push({ letter: key });
            }
        },

        removeTile() {
            this.guesses[this.currentRow].pop();
        },

        shareResult() {
            console.log("share button clicked");
            let text = this.getResultText();
            if (navigator.share) {
                navigator
                    .share({
                        title: "Here's my Colourdle result!",
                        url: "https://colourdle.com",
                        text: text,
                    })
                    .then(() => {
                        console.log("Thanks for sharing!");
                    })
                    .catch(console.error);
            } else {
                console.log("sharing not supported");
            }
        },

        getResultText() {
            console.log("Getting result text");
            let text =
                "Not to brag, but I completed today's Colourdle in " +
                this.currentRow +
                "/6 attempts. \n\n";

            let rows = this.guesses.map((row) => {
                return row.map((item) => {
                    if (item.status == "distance-0") return "🟩";
                    if (
                        item.status == "distance-1" ||
                        item.status == "distance-2"
                    )
                        return "🟨";
                    if (
                        item.status == "distance-3" ||
                        item.status == "distance-4"
                    )
                        return "🟧";
                    if (
                        item.status == "distance-5" ||
                        item.status == "distance-6"
                    )
                        return "🟥";
                    if (
                        item.status == "distance-7" ||
                        item.status == "distance-8"
                    )
                        return "🟪";
                    if (
                        item.status == "distance-9" ||
                        item.status == "distance-10"
                    )
                        return "🟦";
                    if (
                        item.status == "distance-11" ||
                        item.status == "distance-12" ||
                        item.status == "distance-13"
                    )
                        return "⬛️";
                });
            });

            rows = rows.map((row) => {
                return row.join("") + "\n";
            });

            rows.forEach((row) => {
                text += row;
            });

            return text;
        },

        tryGuess() {
            console.log("Trying Guess");

            // only allow guess if it's a full guess
            if (!this.guessIsComplete()) {
                this.wiggle();
                this.showMessage([
                    "Not enough letters",
                    "You're short a letter or two",
                    "Try pressing your keyboard a few more times",
                    "That's not 5 letters y'know?",
                ]);
                return;
            }

            // only allow guess if it's a word in the dictionary
            if (!this.inWordList(this.guesses[this.currentRow])) {
                this.wiggle();
                this.showMessage([
                    "Not a word last time I checked",
                    "Never heard of it",
                    "What dictionary are you using?",
                    "I don't think that's a word",
                    "Definitely not a word",
                    "You've just made that up",
                    "Doesn't sound like a word to me",
                ]);
                return;
            }

            // Allowable guess.
            this.allowInput = false;

            let correctAnswer = this.wordOfTheDay.split("");
            console.log("correct answer : " + correctAnswer);

            // Check distance away from correct letter for each tile
            this.guesses[this.currentRow].forEach((tile, i) => {
                let distance = this.distanceBetween(
                    this.guesses[this.currentRow][i].letter,
                    correctAnswer[i]
                );
                this.guesses[this.currentRow][i].status =
                    "distance-" + distance;
                console.log(distance);
            });

            // check whether the overall guess is correct
            let guessWord = "";
            this.guesses[this.currentRow].forEach((letter) => {
                guessWord += letter.letter;
            });

            this.currentRow++;
            this.store();

            if (guessWord === this.wordOfTheDay) {
                this.modals.successActive = true;
                this.updateStats("success", this.currentRow);
                this.store(true);

                return;
            }

            // move to the next line
            if (this.currentRow < 6) {
                this.allowInput = true;
                this.store();
            } else {
                this.allowInput = false;
                this.updateStats("fail");
                this.store(true);
                this.modals.failedActive = true;
            }
        },

        distanceBetween(a, b) {
            let alphabet = "abcdefghijklmnopqrstuvwxyz";
            let distance = Math.abs(alphabet.indexOf(a) - alphabet.indexOf(b));
            if (distance > 13) {
                return alphabet.length - distance;
            }
            return distance;
        },

        guessIsComplete() {
            if (this.guesses[this.currentRow].length == 5) return true;
            return false;
        },

        inWordList(word) {
            let wordString = word
                .map((letter) => {
                    return letter.letter;
                })
                .join("");
            if (allWords.includes(wordString)) return true;
            return false;
        },

        wiggle() {
            this.wiggleRow = this.currentRow;
            setTimeout(() => {
                this.wiggleRow = null;
            }, 500);
        },

        showMessage(msg, time = 1500) {
            if (typeof msg === "object") {
                this.message = msg[Math.floor(Math.random() * msg.length)];
            } else {
                this.message = msg;
            }
            if (time > 0) {
                setTimeout(() => {
                    this.message = "";
                }, time);
            }
        },

        updateStats(result, numGuesses = null) {
            console.log("updating stats...");
            console.log(this.stats);
            if (result == "success") {
                this.stats.played++;
                this.stats.wins++;
                this.stats.currentStreak++;
                this.stats.winPercentage = this.stats.wins / this.stats.played;
                if (this.stats.currentStreak >= this.stats.maxStreak)
                    this.stats.maxStreak = this.stats.currentStreak;
                this.stats.guessDistribution["r" + numGuesses]++;
            } else {
                this.stats.played++;
                this.stats.currentStreak = 0;
            }
        },

        store(gameFinished = false) {
            console.log("Storing...");
            let date = new Date();
            let dateString = `${date.getFullYear()}${date.getMonth()}${date.getDate()}`;

            localStorage.setItem("currentRow", this.currentRow);
            localStorage.setItem("guesses", JSON.stringify(this.guesses));
            localStorage.setItem("attemptDate", dateString);
            localStorage.setItem("stats", JSON.stringify(this.stats));

            if (gameFinished) {
                this.sendResultToServer();
            }
        },

        retrieve() {
            let date = new Date();
            let todayDateString = `${date.getFullYear()}${date.getMonth()}${date.getDate()}`;
            if (localStorage.getItem("attemptDate") == todayDateString) {
                if (localStorage.getItem("currentRow"))
                    this.currentRow = localStorage.getItem("currentRow");
                if (localStorage.getItem("guesses"))
                    this.guesses = JSON.parse(localStorage.getItem("guesses"));
            }
            if (localStorage.getItem("stats"))
                this.stats = JSON.parse(localStorage.getItem("stats"));
        },

        getBrowserId() {
            let browserId = localStorage.getItem("browserId");
            if (!browserId) {
                browserId = uuidv4();
                localStorage.setItem("browserId", browserId);
            }
            return browserId;
        },

        sendResultToServer() {
            const browserId = this.getBrowserId();
            const isCorrect = this.modals.successActive;
            const attemptsCount = this.currentRow;
            const guess = this.guesses
                .map((row) => row.map((item) => item.letter).join(""))
                .join(",");

            axios
                .post("/api/attempts" , {
                    browser_id: browserId,
                    guess: guess,
                    is_correct: isCorrect,
                    attempts: attemptsCount,
                })
                .then((response) => {
                    console.log(response.data.message);
                })
                .catch((error) => {
                    console.error("Error saving the result:", error);
                });
        },

        fetchRemoteStats() {

            const browserId = this.getBrowserId();
            axios
                .get("/api/stats/" + browserId)
                .then((response) => {
                    this.dailyCorrectPercentage = response.data.correctPercentage;
                    this.dailyAverageAttempts = response.data.averageAttempts;
                    this.dailyDistribution = response.data.distribution;
                    this.stats.percentileRank = response.data.percentileRank
                })
                .catch((error) => {
                    console.error(
                        "Error fetching the remote stats:",
                        error
                    );
                });

            console.log(this.stats.percentileRank)
        },
    },
});

app.mount("#root");
