<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>
<style>
    /* defines css variable */
    :root {
        --primary: #248;
        --secondary: #fff;
        --tertiary: #fff;
    }

    body {
        font-family: Arial, 'Helvetica', sans-serif;
        background-color: var(--secondary);
        padding: 0px;
        margin: 0px;
    }

    main {
        display: flex;
        justify-content: start;
        align-items: end;
        height: 100vh;
        margin-left: 100px;
    }

    #typer {
        position: relative;
        bottom: 0px;
        width: 100%;
    }

    /* imessage */
    .imessage {

        display: flex;
        flex-direction: column;
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        font-size: 1.25rem;
        margin: 0 auto 1rem;
        max-width: 600px;
        padding: 0.5rem 1.5rem;
    }

    .imessage p {
        border-radius: 1.15rem;
        line-height: 1.25;
        max-width: 75%;
        padding: 0.5rem .875rem;
        position: relative;
        word-wrap: break-word;
    }

    .imessage p::before,
    .imessage p::after {
        bottom: -0.1rem;
        content: "";
        height: 1rem;
        position: absolute;
    }



    p[class^="from-"] {
        margin: 0.5rem 0;
        width: fit-content;
    }

    p.from-me~p.from-me {
        margin: 0.25rem 0 0;
    }

    p.from-me~p.from-me:not(:last-child) {
        margin: 0.25rem 0 0;
    }

    p.from-me~p.from-me:last-child {
        margin-bottom: 0.5rem;
    }

    p.from-them {
        align-items: flex-start;
        background-color: #e5e5ea;
        color: #000;


    }

    p.from-them:last-child {
        /* transform: translateY(100%); */
        animation: moveup 0.5s ease-in-out;
    }

    @keyframes moveup {
        0% {
            transform: translateY(100%)
        }

        100% {
            transform: translateY(0%)
        }
    }

    p.from-them:before {
        border-bottom-right-radius: 0.8rem 0.7rem;
        border-left: 1rem solid #e5e5ea;
        left: -0.35rem;
        transform: translate(0, -0.1rem);
    }

    p.from-them::after {
        background-color: var(--secondary);
        border-bottom-right-radius: 0.5rem;
        left: 20px;
        transform: translate(-30px, -2px);
        width: 10px;
    }


    p[class^="from-"].emoji::before {
        content: none;
    }

    input[name="message"] {
        border: none;
        color: #fff;
    }

    input[name="message"]:focus {
        border: none;
        outline: none;
        color: #fff;
    }
</style>

<body>
    <main>
        <div id="typer" x-data="typing">
            <div class="imessage">
                <div id="template">

                    <template x-for="id in Object.keys(messages)" :key="id">

                        <p x-text="messages[id]" class="from-them existed"></p>

                    </template>
                </div>

                <p x-text="message" x-show="message != ''" class="from-them" style="margin:0;"></p>
                <p x-show="newLine" style="color:#fff">&nbsp;</p>
            </div>
            <input type="text" name="message" x-model="message" autofocus @keyup.enter="pushMessageToArray">
            <br>
        </div>
    </main>
    <script>

        document.addEventListener('alpine:init', () => {
            Alpine.data('typing', () => ({
                message: '',
                newLine: false,
                messages: [],
                init() {
                    this.$watch('message', () => {
                        if (this.message != '') {
                            this.newLine = false;
                        }
                    })
                },


                pushMessageToArray() {
                    // select not last child from p from-them class
                    let myList = Array.from(document.querySelectorAll('.from-them'));
                    myList.map((item) => {
                        // get previous element height
                        let prevHeight = item.previousElementSibling.getBoundingClientRect().height;
                        let itemHeight = item.getBoundingClientRect().height;
                        // debugger;
                        item.animate(
                            {
                                transform: [`translateY(44px)`, `translateY(0)`]
                            },
                            {
                                duration: 500,
                                easing: 'ease-in-out',
                                fill: 'forwards'
                            }
                        )
                    });
                    if (this.messages.length >= 4) {
                        // get first element of from-them class
                        let firstElement = document.querySelector('.from-them');
                        // make animation fade out
                        firstElement.animate(
                            {
                                opacity: [1, 0]
                            },
                            {
                                duration: 500,
                                easing: 'ease-in-out',
                                fill: 'forwards'
                            }
                        )
                       // remove first element
                        this.messages.shift();


                    }
                    this.newLine = true;
                    // make animation up

                    if (this.message != '') {
                        // this.newLine = false;
                        this.messages.push(this.message + ' ');
                        // console.log(this.messages);
                        this.message = '';
                    }
                }
            }))
        })
    </script>
</body>

</html>
