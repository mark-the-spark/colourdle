require('./bootstrap');

import { createApp } from 'vue';
import TileRowComponent from './components/TileRowComponent.vue';
import { allWords, getWordOfTheDay } from './src/words.js';
import KeyButton from './components/KeyButton.vue';
import GameModal from './components/GameModal';

var app = createApp({

    data() {
        return {
            guesses: [
                [], [], [], [], [], []
            ],
            currentRow: 0,
            letterStates: {
                a: '', b: '', c: '', d: '', e: '', f: '', g: '', h: '', i: '', j: '', k: '', l: '', m: '', n: '', o: '', p: '', q: '', r: '', s: '', t: '', u: '', v: '', w: '', x: '', y: '', z: ''
            },
            allowInput: true,
            message: '',
            modals: {
                successActive: false,
                helpActive: true,
                failedActive: false

            },
            wiggleRow: null,
            wordOfTheDay: null
        }
    },

    components: {
        tileRow: TileRowComponent,
        KeyButton,
        GameModal
    },

    mounted() {
        this.wordOfTheDay = getWordOfTheDay();
        window.addEventListener("keydown", e => {
            this.keyWasPressed(e.key);

        });
    },

    methods: {

        keyWasPressed(key) {
            if (!this.allowInput) return;

            if (/^[a-zA-Z]$/.test(key)) {
                this.addTile(key);
            }
            if (key === 'Backspace') {
                this.removeTile();
            }

            if (key === 'Enter') {
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
            console.log('share button clicked');
            if (navigator.share) {
                navigator.share({
                    title: 'WebShare API Demo',
                    url: 'https://codepen.io/ayoisaiah/pen/YbNazJ'
                }).then(() => {
                    console.log('Thanks for sharing!');
                })
                    .catch(console.error);
            } else {
                console.log('sharing not supported');
            }
        },

        tryGuess() {

            console.log('Trying Guess');

            // only allow guess if it's a full guess
            if (!this.guessIsComplete()) {
                this.wiggle();
                this.showMessage([
                    'Not enough letters',
                ]);
                return;
            }

            // only allow guess if it's a word in the dictionary
            if (!this.inWordList(this.guesses[this.currentRow])) {
                this.wiggle();
                this.showMessage([
                    'Not a word last time I checked',
                    'I don\'t think that\'s a word',
                    'Definitely not a word',
                    'You\'ve just made that up',
                    'Doesn\'t sound like a word to me'
                ]);
                return;
            }

            this.allowInput = false;

            let correctAnswer = this.wordOfTheDay.split('');
            console.log('correct answer : ' + correctAnswer);
            // Check distance away from correct letter for each tile
            this.guesses[this.currentRow].forEach((tile, i) => {
                let distance = this.distanceBetween(this.guesses[this.currentRow][i].letter, correctAnswer[i]);
                this.guesses[this.currentRow][i].status = 'distance-' + distance;
                console.log(distance);
            });

            // check whether the overall guess is correct
            let guessWord = '';
            this.guesses[this.currentRow].forEach(letter => {
                guessWord += letter.letter;
            });

            if (guessWord === this.wordOfTheDay) {
                this.modals.successActive = true;
                return;
            }

            // move to the next line
            if (this.currentRow < 5) {
                this.currentRow++;
                this.allowInput = true;
            } else {
                this.modals.failedActive = true;
            }


        },

        distanceBetween(a, b) {
            let alphabet = 'abcdefghijklmnopqrstuvwxyz'
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
            let wordString = word.map(letter => {
                return letter.letter;
            }).join('');
            if (allWords.includes(wordString)) return true;
            return false;
        },

        wiggle() {
            this.wiggleRow = this.currentRow;
            setTimeout(() => { this.wiggleRow = null }, 500);
        },

        showMessage(msg, time = 1500) {
            if (typeof (msg) === 'object') {
                this.message = msg[Math.floor(Math.random() * msg.length)];
            } else {
                this.message = msg;
            }
            if (time > 0) {
                setTimeout(() => {
                    this.message = ''
                }, time)
            }
        }
    }
})

app.mount('#root');

