<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>yourstruly</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=albert-sans:400,400i,700,700i" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=bilbo-swash-caps:400" rel="stylesheet" />
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    <style>
        .animation-top {
            animation: flx 1.8s infinite linear;
            animation-timing-function: linear;
            animation-iteration-count: infinite;
            animation-direction: alternate;
            transform-origin: left bottom;
            top: -1em;
            left: -1em;
            position: absolute;
        }
        .animation-bottom {
            animation: flz 1.8s infinite ease-in-out;
            animation-timing-function: linear;
            animation-iteration-count: infinite;
            animation-direction: alternate;
            transform-origin: left bottom;
            bottom: 0;
            right: 0;
            position: absolute;
        }

        @keyframes flx {
            from {
                transform:  scale(1) translate(0px, 0px) rotate(5deg)
            }

            to {
                transform:  scale(1.1) translate(1em, 1em) rotate(0deg)
            }
        }

        @keyframes flz {
            from {
                transform:  scale(1.1) translate(1em, 1em)
            }

            to {
                transform:  scale(1) translate(0px, 0px)
            }
        }

        @keyframes fla {
            from {
                transform: rotate(-3deg) scale(1)
            }

            to {
                transform: rotate(0deg) scale(1.05)
            }
        }

        @keyframes flb {
            from {
                transform: rotate(0deg) scale(1)
            }

            to {
                transform: rotate(-3deg) scale(1.05)
            }
        }

        @keyframes flc {
            from {
                transform: rotate(5deg) scale(1)
            }

            to {
                transform: rotate(0deg) scale(1.05)
            }
        }

        @keyframes fld {
            from {
                transform: rotate(2deg) scale(1)
            }

            to {
                transform: rotate(-2deg) scale(1.1)
            }
        }
    </style>
</head>

<body>
    <div class="h-screen w-full bg-[#072a38] max-w-xl relative overflow-hidden mx-auto">
        <div class="w-full h-screen">
            <img class="animation-top" src="{{ asset('images/yourstruly/florals/top1.png') }}" />
            <img class="animation-bottom" src="{{ asset('images/yourstruly/florals/bot1.png') }}" />
            {{-- <img class="w-full h-screen object-cover" src="{{ asset('images/yourstruly/1.jpg') }}" alt=""> --}}
        </div>
        <div class="py-2 absolute drop-shadow-xl bottom-2 right-0  text-4xl font-bilbo  px-4 flex z-10  ">
            Yourstruly
        </div>
    </div>
</body>

</html>
