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
    <meta property="og:image" content="{{ asset('images/profile.png') }}">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:type" content="website">

    <!-- Twitter Card tags for social media -->
    <meta name="twitter:title" content="👋 Frenki Herlambang | Fullstack Dev ">
    <meta name="twitter:description"
        content="a full-stack developer specializing in Laravel, and an indie hacker with a passion for creating digital products and SaaS businesses">
    <meta name="twitter:image" content="{{ asset('images/profile.png') }}">
    <meta name="twitter:card" content="summary_large_image">
    <link rel="apple-touch-icon" sizes="128x128" href="{{ asset('images/profile.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/profile.png') }}">
    @vite(['resources/js/app.js', 'resources/css/app.css'])
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
                            <a class="text-gray-500 transition hover:text-gray-500/75" href="https://portofolio.frenki.id">
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



                    <div x-data="{ isActive: false }" class="relative">
                        <div
                            class="inline-flex items-center overflow-hidden bg-white border divide-x divide-gray-100 rounded-md">


                            <button x-on:click="isActive = !isActive" type="button"
                                class="block rounded bg-gray-100 p-2.5 text-gray-600 transition hover:text-gray-600/75 md:hidden">
                                <span class="sr-only">Toggle menu</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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

                                <a href="#"
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


    <main class="flex">
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

                        <a href="#"
                            class="block py-2 text-sm text-gray-500 rounded-lg hover:bg-gray-50 hover:text-gray-700"
                            role="menuitem">
                            Projects
                        </a>

                        <a href="{{ route('blog') }}"
                            class="block py-2 text-sm text-gray-500 rounded-lg hover:bg-gray-50 hover:text-gray-700"
                            role="menuitem">
                            Blog
                        </a>
                    </div>


                </nav>
            </div>
        </div>
        <div class="flex pt-12 items-center justify-center w-full">
            <section class="max-w-5xl px-4 md:py-14">
                <h1 class="text-3xl font-bold mb-4">Portfolio</h1>
                <p class="mb-4">Hello! I'm Frenki Herlambang Prasetyo, and I'd like to share a
                    highlight from my previous projects as a Laravel Fullstack
                    Developer as well as Laravel Backend Developer.</p>
                <h2 class="flex justify-between">
                    <div class="text-xl font-bold">Tevocs.id</div>
                    <div class="text-gray-500 text-sm font-normal">
                        Aug 2020 - Nov 2020
                    </div>
                </h2>
                <div  class="flex flex-col gap-4 text-justify">
                    <p>
                        Developing TEVocS ( Test of English for Vocational Students) a Computer Based Test currently used as
                        a graduation requirement for SV UGM students. Tevocs was developed using laravel framework.
                    </p>
                    <p>
                        TEVocS is a web-based application that enables users to take online tests in the English language.
                        It is designed to help vocational students prepare for their English language exams and improve
                        their language proficiency.
                    </p>
                    <p>
                        The application is built to provide an easy-to-use interface for users and it includes features that
                        help users prepare for their exams in a more efficient manner. TEVocS provides users with a variety
                        of tests that can be customized to meet their specific needs. The tests are divided into different
                        levels, from beginner to advanced, and each test can be tailored to the user's language proficiency
                        level.
                    </p>
                    <p>
                        In addition to providing tests, TEVocS also provides users with feedback on their performance, as
                        well as tips and advice for improving their language skills. The application keeps track of users'
                        progress over time and provides them with detailed reports of their performance.
                    </p>
                    <p>
                        TEVocS is designed to be secure, easy to use, and reliable. The application is encrypted and uses
                        secure sockets layer (SSL) technology to ensure a safe and secure environment for users. The
                        application also uses a number of technologies, such as HTML5, CSS3, and JavaScript, to ensure a
                        smooth and reliable user experience.</p>
                </div>

                <h2 class="flex justify-between mt-8">
                    <div class="text-xl font-bold">Multimedia Asset Management System</div>
                    <div class="text-gray-500 text-sm font-normal">
                        Feb 2020 - May 2020
                    </div>
                </h2>
                <div  class="flex flex-col gap-4 text-justify">
                    <p>
                        As a Backend Engineer, I built a backend service with laravel framework for Multimedia Asset Management and CCTV Management for jogjaprov.go.id
                    </p>
                    <p>
                        Here are the work I do:
                    </p>
                    <p>
                        1. Database Design: The backend service start from designing a database to store all the multimedia assets and CCTV records. The database design include tables for multimedia assets and CCTV lists.
                    </p>
                    <p>
                        2. API Development: The backend service include an API to enable the Yogyakarta City Government to access and manage the multimedia assets and CCTV records. The API can be use to add, update, and delete records as well as provide search and filtering functions and synchronized with Wowza Streaming Engine.
                    </p>
                    <p>
                        3. Security: The backend service includes security measures to ensure that only authorized personnel can access the multimedia assets and CCTV records. The security measures should include authentication and authorization as well as encryption of data.
                    </p>
                </div>


                <h2 class="flex justify-between mt-8">
                    <div class="text-xl font-bold">
                        ABKIN Membership Registration System</div>
                    <div class="text-gray-500 text-sm font-normal">
                        Jan 2019 - May 2019
                    </div>
                </h2>
                <div  class="flex flex-col gap-4 text-justify">
                    <p>
                        1. Develop a membership registration system that allows for the collection of member information and details about the counseling professional associations. This system should include the ability to collect basic personal information, contact details, and eligibility requirements for membership.
                    </p>
                    <p>
                        2. Create a secure online portal for members to log in and access their profiles, membership information, and other resources. This portal should also allow members to update their profile information and pay their membership dues,
                    </p>
                    <p>
                        3. Design a payment system that allows members to pay their membership dues and any other fees associated with the association.
                    </p>
                    <p>
                        4. Develop a notification system via email that can be used to send out reminders of upcoming events, dues payments, or other important information to members.
                    </p>
                    <p>
                        5. Create a searchable database of members with the ability to search by name, specialty, or location. This database only accessible to members only and should be regularly updated.
                    </p>
                </div>
               
            </section>
        </div>
    </main>

    @livewireScripts
</body>

</html>
