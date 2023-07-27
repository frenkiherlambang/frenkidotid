<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>👋 Frenki Herlambang | Fullstack Dev </title>
    <meta name="description"
        content="a full-stack developer specializing in Laravel, and an indie hacker with a passion for creating digital products and SaaS businesses">
    <meta name="keywords" content="full-stack developer, indie hacker, Laravel, SaaS, coffee">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index,follow">
    <link rel="canonical" href="{{ url('/') }}">
    <!-- Open Graph Protocol tags for social media -->
    <meta property="og:title" content="👋 Frenki Herlambang | Fullstack Dev ">
    <meta property="og:description"
        content="a full-stack developer specializing in Laravel, and an indie hacker with a passion for creating digital products and SaaS businesses">
    <meta property="og:image" content="{{asset('images/profile.png')}}">
    <meta property="og:url" content="{{url('/')}}">
    <meta property="og:type" content="website">

    <!-- Twitter Card tags for social media -->
    <meta name="twitter:title" content="👋 Frenki Herlambang | Fullstack Dev ">
    <meta name="twitter:description"
        content="a full-stack developer specializing in Laravel, and an indie hacker with a passion for creating digital products and SaaS businesses">
    <meta name="twitter:image" content="{{asset('images/profile.png')}}">
    <meta name="twitter:card" content="summary_large_image">
    <link rel="apple-touch-icon" sizes="128x128" href="{{asset('images/profile.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('images/profile.png')}}">
    @vite([
    'resources/js/app.js',
    'resources/css/app.css',
    ])
    @livewireStyles
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Heebo', sans-serif;
        }

        /* cloak */
        [x-cloak] {
            display: none;
        }
    </style>

</head>

<body>
    <header aria-label="Site Header" class="bg-white md:hidden ">
        <div class="flex items-center h-16 max-w-screen-xl gap-8 px-4 mx-auto sm:px-6 lg:px-8">
            <a class="block text-xl font-bold text-black" href="/">
                Frenki Herlambang
            </a>

            <div class="flex items-center justify-end flex-1 md:justify-between">
                <nav aria-label="Site Nav" class="hidden md:block">
                    <ul class="flex items-center gap-6 text-sm">
                        <li>
                            <a class="text-gray-500 transition hover:text-gray-500/75" href="/">
                                About
                            </a>
                        </li>

                        <li>
                            <a class="text-gray-500 transition hover:text-gray-500/75" href="https://portfolio.frenki.id">
                                Projects
                            </a>
                        </li>

                        <li>
                            <a class="text-gray-500 transition hover:text-gray-500/75" href="/">
                                Blog
                            </a>
                        </li>
                    </ul>
                </nav>

                <div class="flex items-center gap-4">
                    {{-- <div class="sm:flex sm:gap-4">
                        <a class="block rounded-md bg-teal-600 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-teal-700"
                            href="/">
                            Login
                        </a>

                        <a class="hidden rounded-md bg-gray-100 px-5 py-2.5 text-sm font-medium text-teal-600 transition hover:text-teal-600/75 sm:block"
                            href="/">
                            Register
                        </a>
                    </div> --}}



                    <div x-data="{ isActive: false }" class="relative">
                        <div
                            class="inline-flex items-center overflow-hidden bg-white border divide-x divide-gray-100 rounded-md">


                            <button x-on:click="isActive = !isActive" type="button"
                                class="block rounded bg-gray-100 p-2.5 text-gray-600 transition hover:text-gray-600/75 md:hidden">
                                <span class="sr-only">Toggle menu</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                        </div>

                        <div class="absolute right-0 z-10 w-56 mt-2 bg-white border border-gray-100 rounded-md shadow-lg"
                            role="menu" x-cloak x-transition x-show="isActive" x-on:click.away="isActive = false"
                            x-on:keydown.escape.window="isActive = false">
                            <div class="p-2">
                                <a href="#"
                                    class="block px-4 py-2 text-sm text-gray-500 rounded-lg hover:bg-gray-50 hover:text-gray-700"
                                    role="menuitem">
                                    About
                                </a>

                                <a href="https://portofolio.frenki.id"
                                    class="block px-4 py-2 text-sm text-gray-500 rounded-lg hover:bg-gray-50 hover:text-gray-700"
                                    role="menuitem">
                                    Projects
                                </a>

                                <a href="#"
                                    class="block px-4 py-2 text-sm text-gray-500 rounded-lg hover:bg-gray-50 hover:text-gray-700"
                                    role="menuitem">
                                    Blog
                                </a>

                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </header>


    <main class="flex md:h-screen h-[calc(100vh-64px)] ">
        <div
            class="flex-col items-center justify-center hidden pt-5 pb-4 overflow-y-auto align-middle bg-white border-r border-gray-200 shadow md:flex min-w-fit">
            <div class="flex items-center flex-shrink-0 px-4">

            </div>
            <div class="flex flex-col justify-center flex-grow">

                <nav class="flex flex-col justify-center flex-1 px-8 mx-8 space-y-1 bg-white" aria-label="Sidebar">
                    <!-- Current: "bg-gray-100 text-gray-900", Default: "text-gray-600 hover:bg-gray-50 hover:text-gray-900" -->
                    <a class="block mb-8 text-3xl font-bold text-black" href="/">
                        Frenki<br>
                        Herlambang
                    </a>
                    <div class="mb-8">
                        <a href="#"
                            class="block py-2 text-sm text-gray-500 rounded-lg hover:bg-gray-50 hover:text-gray-700"
                            role="menuitem">
                            About
                        </a>

                        <a href="https://portofolio.frenki.id"
                            class="block py-2 text-sm text-gray-500 rounded-lg hover:bg-gray-50 hover:text-gray-700"
                            role="menuitem">
                            Projects
                        </a>

                        <a href="{{route('blog')}}"
                            class="block py-2 text-sm text-gray-500 rounded-lg hover:bg-gray-50 hover:text-gray-700"
                            role="menuitem">
                            Blog
                        </a>
                    </div>


                </nav>
            </div>
        </div>
        <div class="flex items-center max-w-md mx-auto lg:max-w-5xl">

            <article class="flex max-w-5xl mx-8 transition bg-white hover:shadow-xl">
                <div class="rotate-180 hidden p-2 [writing-mode:_vertical-lr]">
                    <time datetime="{{now()->format('Y-m-d')}} "
                        class="flex items-center justify-between gap-4 text-xs font-bold text-gray-900 uppercase">
                        <span>{{now()->format('Y')}}</span>
                        <span class="flex-1 w-px bg-gray-900/10"></span>
                        <span>{{now()->format('M-d')}}</span>
                    </time>
                </div>
                <div class="flex flex-col lg:flex-row">
                    <div class="p-8 md:p-0 sm:basis-56">
                        <img alt="frenki" src="{{asset('images/profile.png')}}"
                            class="object-cover md:w-full md:h-full aspect-square" />
                    </div>

                    <div class="flex flex-col justify-between flex-1 p-4 pt-0 md:p-0">
                        <div class="p-2 border-l border-gray-900/10 sm:border-l-transparent sm:p-6">
                            <a href="#">
                                <h3 class="text-3xl font-bold text-gray-900">
                                    Hello
                                </h3>
                            </a>

                            <p class="mt-2 text-sm leading-relaxed text-justify text-gray-700 line-clamp-3">

                                I'm Frenki, a full-stack developer specializing in Laravel, and an indie hacker with a
                                passion for creating digital products and SaaS businesses. I value clean code and
                                continuous learning, and when I'm not coding, I love sipping coffee and keeping up with
                                the latest tech news. Let's chat about tech, coffee, or potential collaboration
                                opportunities!
                            </p>
                        </div>

                        <div class="sm:flex sm:items-end sm:justify-end">
                            <a href="#"
                                class="block px-5 py-3 text-xs font-bold text-center text-gray-900 uppercase transition bg-yellow-300 hover:bg-yellow-400">
                                Read Blog
                            </a>
                        </div>
                    </div>
                </div>

            </article>

        </div>
    </main>

    @livewireScripts
</body>

</html>
