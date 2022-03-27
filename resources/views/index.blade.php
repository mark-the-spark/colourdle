<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    <title>Colordle</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Abril+Fatface&display=swap');
    </style>
</head>

<body>
    <div id="root">
        <nav class="navbar" role="navigation" aria-label="main navigation">
            <div class="navbar-brand">
                <a class="navbar-item" href="#" @click="modals.helpActive = true"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24"
                        width="24">
                        <path fill="var(--color-tone-1)"
                            d="M11 18h2v-2h-2v2zm1-16C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm0-14c-2.21 0-4 1.79-4 4h2c0-1.1.9-2 2-2s2 .9 2 2c0 2-3 1.75-3 5h2c0-2.25 3-2.5 3-5 0-2.21-1.79-4-4-4z">
                        </path>
                    </svg></a>
            </div>
            <a class="navbar-item" href="#">
                <h1 class="center is-size-3 has-text-weight-bold">
                    <span class="distance-12-letter">C</span>
                    <span class="distance-1-letter">o</span>
                    <span class="distance-4-letter">l</span>
                    <span class="distance-10-letter">o</span>
                    <span class="distance-3-letter">u</span>
                    <span class="distance-7-letter">r</span>
                    <span class="distance-2-letter">d</span>
                    <span class="distance-9-letter">l</span>
                    <span class="distance-6-letter">e</span>
                    </h1>
            </a>
            <a class="navbar-item" href="#">
                <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                    <path fill="var(--color-tone-1)"
                        d="M16,11V3H8v6H2v12h20V11H16z M10,5h4v14h-4V5z M4,11h4v8H4V11z M20,19h-4v-6h4V19z"></path>
                </svg>
            </a>
        </nav>
        <div class="container ">
            <div class="key">
                <div class="key-item distance-13">
                </div>
                <div class="key-item distance-9">
                </div>
                <div class="key-item distance-7">
                </div>
                <div class="key-item distance-6">
                </div>
                <div class="key-item distance-5">
                </div>
                <div class="key-item distance-4">
                </div>
                <div class="key-item distance-2">
                </div>
                <div class="key-item distance-0">
                </div>
            </div>
            <div class="key-text">
                <div>Cold</div>
                <div>Warm</div>
            </div>
            <tile-row :guess="guesses[0]" :class="wiggleRow == 0 ? 'wiggle' : '' "></tile-row>
            <tile-row :guess="guesses[1]" :class="wiggleRow == 1 ? 'wiggle' : '' "></tile-row>
            <tile-row :guess="guesses[2]" :class="wiggleRow == 2 ? 'wiggle' : '' "></tile-row>
            <tile-row :guess="guesses[3]" :class="wiggleRow == 3 ? 'wiggle' : '' "></tile-row>
            <tile-row :guess="guesses[4]" :class="wiggleRow == 4 ? 'wiggle' : '' "></tile-row>
            <tile-row :guess="guesses[5]" :class="wiggleRow == 5 ? 'wiggle' : '' "></tile-row>
            <div class="keyboard">
                <div class="row">
                    <key-button @pressed="keyWasPressed" keystroke="q" :state="letterStates.q">q</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="w" :state="letterStates.w">w</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="e" :state="letterStates.e">e</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="r" :state="letterStates.r">r</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="t" :state="letterStates.t">t</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="y" :state="letterStates.y">y</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="u" :state="letterStates.u">u</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="i" :state="letterStates.i">i</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="o" :state="letterStates.o">o</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="p" :state="letterStates.p">p</key-button>
                </div>
                <div class="row">
                    <key-button @pressed="keyWasPressed" keystroke="a" :state="letterStates.a">a</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="s" :state="letterStates.s">s</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="d" :state="letterStates.d">d</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="f" :state="letterStates.f">f</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="g" :state="letterStates.g">g</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="h" :state="letterStates.h">h</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="j" :state="letterStates.j">j</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="k" :state="letterStates.k">k</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="l" :state="letterStates.l">l</key-button>
                </div>
                <div class="row">
                    <key-button @pressed="keyWasPressed" keystroke="Enter">enter</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="x" :state="letterStates.x">x</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="z" :state="letterStates.z">z</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="c" :state="letterStates.c">c</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="v" :state="letterStates.v">v</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="b" :state="letterStates.b">b</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="n" :state="letterStates.n">n</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="m" :state="letterStates.m">m</key-button>
                    <key-button @pressed="keyWasPressed" keystroke="Backspace"><svg xmlns="http://www.w3.org/2000/svg"
                            height="24" viewBox="0 0 24 24" width="24">
                            <path fill="var(--color-tone-1)"
                                d="M22 3H7c-.69 0-1.23.35-1.59.88L0 12l5.41 8.11c.36.53.9.89 1.59.89h15c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H7.07L2.4 12l4.66-7H22v14zm-11.59-2L14 13.41 17.59 17 19 15.59 15.41 12 19 8.41 17.59 7 14 10.59 10.41 7 9 8.41 12.59 12 9 15.59z">
                            </path>
                        </svg></key-button>
                </div>

            </div>
        </div>
        <game-modal :active="modals.successActive" @closed="modals.successActive = false">
            <div class="box">
                <h2>Well done! You sure know your colors.</h2>
            </div>
        </game-modal>
        <game-modal :active="modals.helpActive" @closed="modals.helpActive = false">
            <div class="box">
                <h2>Here's how it all works</h2>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ad cumque voluptatibus provident neque quisquam voluptatem eum ipsa dignissimos exercitationem. Similique quis veritatis tempore dicta deserunt porro commodi eaque animi nemo?.</p>
            </div>
        </game-modal>
        <game-modal :active="modals.failedActive" @closed="modals.failedActive = false">
            <div class="box">
                <h2>You didn't get the word in time. Too bad.</h2>
                <p>Try practicing a little bit more.</p>
            </div>
        </game-modal>
    </div>



    <script src="js/app.js"></script>

</body>

</html>
