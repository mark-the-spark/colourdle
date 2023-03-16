<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    <title>Colourdle - The Original World-Colour Guessing Game!</title>
    <meta name="description" content="Colourdle is a fun and challenging game where you have to guess the word from the colours - try it and see how you compare!">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Abril+Fatface&display=swap');
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-7GZNMWKD28"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-7GZNMWKD28');
    </script>
</head>

<body>
    <div id="root">
        <nav class="navbar" role="navigation" aria-label="main navigation">
            <div class="navbar-brand">
                <a class="navbar-item" href="#" @click="modals.helpActive = true"><svg
                        xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                        <path fill="var(--color-tone-1)"
                            d="M11 18h2v-2h-2v2zm1-16C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm0-14c-2.21 0-4 1.79-4 4h2c0-1.1.9-2 2-2s2 .9 2 2c0 2-3 1.75-3 5h2c0-2.25 3-2.5 3-5 0-2.21-1.79-4-4-4z">
                        </path>
                    </svg></a>
            </div>
            <a class="navbar-item" href="#">
                <h1 class="center is-size-3 has-text-weight-bold is-flex">
                    <div class="tile tile-x-small distance-0"><span class="">C</span></div>
                    <div class="tile tile-x-small distance-6"><span class="">o</span></div>
                    <div class="tile tile-x-small distance-2"><span class="">l</span></div>
                    <div class="tile tile-x-small distance-9"><span class="">o</span></div>
                    <div class="tile tile-x-small distance-5"><span class="">u</span></div>
                    <div class="tile tile-x-small distance-13"><span class="">r</span></div>
                    <div class="tile tile-x-small distance-2"><span class="">d</span></div>
                    <div class="tile tile-x-small distance-7"><span class="">l</span></div>
                    <div class="tile tile-x-small distance-3"><span class="">e</span></div>
                </h1>
            </a>
            <a class="navbar-item" href="#" @click="modals.statsActive = true">
                <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                    <path fill="var(--color-tone-1)"
                        d="M16,11V3H8v6H2v12h20V11H16z M10,5h4v14h-4V5z M4,11h4v8H4V11z M20,19h-4v-6h4V19z"></path>
                </svg>
            </a>
        </nav>
        <div class="game-container">
            <div class="board">
                <div class="color-key">

                    <div class="key-item distance-12">
                    </div>
                    <div class="key-item distance-10">
                    </div>
                    <div class="key-item distance-8">
                    </div>
                    <div class="key-item distance-6">
                    </div>
                    <div class="key-item distance-4">
                    </div>
                    <div class="key-item distance-2">
                    </div>
                    <div class="key-item distance-0 ml-2">
                    </div>
                </div>
                <div class="key-text">
                    <div>Cold</div>
                    <div>Warmer</div>
                    <div>Correct!</div>
                </div>
                <tile-row :guess="guesses[0]" :class="wiggleRow == 0 ? 'wiggle' : ''"></tile-row>
                <tile-row :guess="guesses[1]" :class="wiggleRow == 1 ? 'wiggle' : ''"></tile-row>
                <tile-row :guess="guesses[2]" :class="wiggleRow == 2 ? 'wiggle' : ''"></tile-row>
                <tile-row :guess="guesses[3]" :class="wiggleRow == 3 ? 'wiggle' : ''"></tile-row>
                <tile-row :guess="guesses[4]" :class="wiggleRow == 4 ? 'wiggle' : ''"></tile-row>
                <tile-row :guess="guesses[5]" :class="wiggleRow == 5 ? 'wiggle' : ''"></tile-row>
            </div>
            <div class="keyboard">
                <div class="keyboard-row">
                    <key-button @pressed="keyWasPressed" keystroke="q">q</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="w">w</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="e">e</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="r">r</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="t">t</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="y">y</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="u">u</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="i">i</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="o">o</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="p">p</key-button>


                </div>
                <div class="keyboard-row">
                    <div class="spacer-half"></div>
                    <key-button @pressed="keyWasPressed" keystroke="a">a</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="s">s</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="d">d</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="f">f</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="g">g</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="h">h</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="j">j</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="k">k</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="l">l</key-button>
                    <div class="spacer-half"></div>

                </div>
                <div class="keyboard-row">
                    <key-button @pressed="keyWasPressed" keystroke="Enter">enter</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="x">x</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="z">z</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="c">c</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="v">v</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="b">b</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="n">n</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="m">m</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="Backspace"><svg xmlns="http://www.w3.org/2000/svg"
                            height="24" viewBox="0 0 24 24" width="24">
                            <path fill="var(--color-tone-1)"
                                d="M22 3H7c-.69 0-1.23.35-1.59.88L0 12l5.41 8.11c.36.53.9.89 1.59.89h15c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H7.07L2.4 12l4.66-7H22v14zm-11.59-2L14 13.41 17.59 17 19 15.59 15.41 12 19 8.41 17.59 7 14 10.59 10.41 7 9 8.41 12.59 12 9 15.59z">
                            </path>
                        </svg></key-button>
                </div>

            </div>
        </div>
        <div class="flash-message" v-if="message" v-cloak>
            @{{ message }}
        </div>

        <game-modal class="hidden" :active="modals.successActive" @closed="modals.successActive = false">
            <div class="px-4 py-5 bg-white flex flex-col items-center rounded-lg">
                <h2 class=" uppercase">Well done!</h2>
                <p class='mb-4'>The correct answer was indeed <span
                        class="font-bold uppercase text-green-500">@{{ wordOfTheDay }} </span></p>


                <div class="mb-2 border-t border-gray-200 w-full pt-3">
                    <p class="text-center font-bold">How everyone else did today</p>
                </div>

                <div class="grid gap-4 grid-cols-2 mb-5">
                    <div class=" bg-gray-200 rounded p-3 flex flex-col items-center">
                        <p class="text-xs font-bold text-center">Percent Correct</p>
                        <p>@{{ dailyCorrectPercentage }}%</p>
                    </div>
                    <div class=" bg-gray-200 rounded p-3 flex flex-col items-center">
                        <p class="text-xs font-bold text-center">Average attempts</p>
                        <p>@{{ dailyAverageAttempts }}</p>
                    </div>

                </div>

                <div class="has-text-centered border-t border-gray-200 pt-3">
                    <p class="text-small mb-3">Fancy bragging about how smart you are?</p>
                    <button class="rounded-full bg-green-500 text-white px-5 py-2" @click="shareResult">
                        <span class="icon is-small">
                            <i class="fa-solid fa-share"></i>
                        </span>
                        <span> Share</span>
                    </button>
                </div>
            </div>
        </game-modal>
        <game-modal class="hidden" :active="modals.helpActive" @closed="modals.helpActive = false">
            <div class="box ">
                <h2 class="has-text-centered">How to play</h2>
                <p class="is-italic has-text-centered">"Like Wordle, but better"</p>
                <p class="quote-name pb-2 has-text-centered">- The NY Times</p>
                <p class="mb-2">Guess the word by using colours. The colour of each tile tells you how close
                    to the correct letter you are.</p>
                <h3 class="font-bold">Examples</h3>
                <div class="is-flex is-align-items-center mb-2">
                    <div class="tile tile-small tile-inline distance-12"><span>A</span></div>
                    <p class="ml-2"> ...the wrong side of the alphabet</p>
                </div>
                <div class="is-flex is-align-items-center mb-2">
                    <div class="tile tile-small tile-inline distance-4"><span>B</span></div>
                    <p class="ml-2"> ...getting closer</p>
                </div>
                <div class="is-flex is-align-items-center mb-2">
                    <div class="tile tile-small tile-inline distance-0"><span>C</span></div>
                    <p class="ml-2"> ...correct!</p>
                </div>
                <p class="mb-2">Sound easy? There is a twist. <span class="font-bold">In Colourdle,
                        "a" is as close to "z" as it is to "b".</span>&#129327;</p>
                <p>Good luck! </p>

            </div>
        </game-modal>
        <game-modal class="hidden" :active="modals.failedActive" @closed="modals.failedActive = false">
            <div class="box">
                <h2 class="has-text-centered">Oh no!</h2>
                <p class='mb-3'>The correct answer was <span
                        class="font-bold is-uppercase">@{{ wordOfTheDay }}</span></p>
                <p>Better luck tomorrow!</p>
            </div>
        </game-modal>

        <game-modal class="hidden" :active="modals.statsActive" @closed="modals.statsActive = false">
            <div class="box">
                <h2 class="has-text-centered">Statistics</h2>
                {{-- <div class="bg-gray-200 rounded-lg p-3">
                    You have more correct guesses than <span class='font-bold'>@{{ stats.percentileRank }}%</span> of Colourdlers!
                </div> --}}
                <div class="is-flex is-justify-content-space-around">
                    <div class="has-text-centered stat-item">
                        <h3>Played</h3>
                        <h4>@{{ stats.played }}</h4>
                    </div>
                    <div class="has-text-centered stat-item">
                        <h3>Win %</h3>
                        <h4>@{{ stats.winPercentage * 100 }}%</h4>
                    </div>
                    <div class="has-text-centered stat-item">
                        <h3>Current Streak</h3>
                        <h4>@{{ stats.currentStreak }}</h4>
                    </div>
                    <div class="has-text-centered stat-item">
                        <h3>Max Streak</h3>
                        <h4>@{{ stats.maxStreak }}</h4>
                    </div>

                </div>
                <h3 class="has-text-centered has-text-weight-bold mt-3">Guess Distribution</h3>
                <div class="is-flex is-justify-content-space-around">
                    <div class="has-text-centered stat-item">
                        <h3>1</h3>
                        <h4>@{{ stats.guessDistribution.r1 }}</h4>
                    </div>
                    <div class="has-text-centered stat-item">
                        <h3>2</h3>
                        <h4>@{{ stats.guessDistribution.r2 }}</h4>
                    </div>
                    <div class="has-text-centered stat-item">
                        <h3>3</h3>
                        <h4>@{{ stats.guessDistribution.r3 }}</h4>
                    </div>
                    <div class="has-text-centered stat-item">
                        <h3>4</h3>
                        <h4>@{{ stats.guessDistribution.r4 }}</h4>
                    </div>
                    <div class="has-text-centered stat-item">
                        <h3>5</h3>
                        <h4>@{{ stats.guessDistribution.r5 }}</h4>
                    </div>
                    <div class="has-text-centered stat-item">
                        <h3>6</h3>
                        <h4>@{{ stats.guessDistribution.r6 }}</h4>
                    </div>
                </div>
                <div class="has-text-centered">
                    <button class="button is-success" @click="shareResult">
                        <span class="icon is-small">
                            <i class="fa-solid fa-share"></i>
                        </span>
                        <span>Share</span>
                    </button>
                </div>
            </div>
        </game-modal>


    </div>
</body>
<script type="application/javascript" src="js/app.js"></script>

</html>
