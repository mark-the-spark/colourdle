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
                a: '', b: '', c: '', d: '', e: '',f: '',g: '',h: '',i: '',j: '',k: '',l: '',m: '',n: '',o: '',p: '',q: '',r: '',s: '',t: '',u: '',v: '',w: '',x: '',y: '',z: ''
            },
            allowInput: true,
            modals: {
                successActive: false,
                helpActive: false,
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
            if (! this.allowInput) return;

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

        tryGuess() {
           
            console.log('Trying Guess');

            // only allow guess if it's a full guess
           if (!this.guessIsComplete()) {
                return;
            }

            // only allow guess if it's a word in the dictionary
            if (!this.inWordList(this.guesses[this.currentRow])) {
                this.wiggle();
                return;
            }

            this.allowInput = false;

            let correctAnswer = this.wordOfTheDay.split('');
            console.log('correct answer : ' + correctAnswer);
            // Check distance away from correct letter for each tile
            this.guesses[this.currentRow].forEach((tile, i) => {
                let distance = this.distanceBetween( this.guesses[this.currentRow][i].letter , correctAnswer[i]);
                this.guesses[this.currentRow][i].status = 'distance-' + distance;
                console.log(distance);
            });



            // // first pass - mark correct tiles
            // this.guesses[this.currentRow].forEach((tile, i) => {
            //     if (tile.letter == correctAnswer[i]) {
            //         console.log(`${tile.letter} is correct`);
            //         this.guesses[this.currentRow][i].status = 'correct';
            //         this.letterStates[tile.letter] = 'correct'
            //         correctAnswer[i] = null;
            //     } 
            // })
            // // second pass - present tiles
            // this.guesses[this.currentRow].forEach((tile, i) => {
            //     if (this.guesses[this.currentRow][i].status == undefined && correctAnswer.includes(tile.letter)) {
            //         console.log(`status ${this.guesses[this.currentRow][i].status}`);
            //         console.log(`${tile.letter} is present`);
            //         this.guesses[this.currentRow][i].status = 'present';
            //         this.letterStates[tile.letter] = 'present'
            //         correctAnswer[correctAnswer.indexOf(tile.letter)] = null;
            //     } 
            // })

            // // final pass 
            // this.guesses[this.currentRow].forEach((tile, i) => {
            //     if (this.guesses[this.currentRow][i].status == undefined) {
            //         console.log(`status ${this.guesses[this.currentRow][i].status}`);
            //         console.log(`${tile.letter} is incorrect`);
            //         this.guesses[this.currentRow][i].status = 'incorrect';
            //         this.letterStates[tile.letter] = 'incorrect'
            //     }
            // });

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

        distanceBetween(a,b) {
            let alphabet = 'abcdefghijklmnopqrstuvwxyz'
            let distance = Math.abs(alphabet.indexOf(a) -  alphabet.indexOf(b));
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
            if(allWords.includes(wordString)) return true;
            return false;
        },

        wiggle() {
            this.wiggleRow = this.currentRow;
            setTimeout(() => {this.wiggleRow = null}, 500);
        }
    }
})

app.mount('#root');

