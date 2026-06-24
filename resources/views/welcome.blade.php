<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? 'Service Center | Company Profile' }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    {{-- maps --}}
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Styles -->
    <style>
        /* ! tailwindcss v3.2.4 | MIT License | https://tailwindcss.com */
        *,
        ::after,
        ::before {
            box-sizing: border-box;
            border-width: 0;
            border-style: solid;
            border-color: #e5e7eb
        }

        ::after,
        ::before {
            --tw-content: ''
        }

        html {
            line-height: 1.5;
            -webkit-text-size-adjust: 100%;
            -moz-tab-size: 4;
            tab-size: 4;
            font-family: Figtree, sans-serif;
            font-feature-settings: normal
        }

        body {
            margin: 0;
            line-height: inherit
        }

        hr {
            height: 0;
            color: inherit;
            border-top-width: 1px
        }

        abbr:where([title]) {
            -webkit-text-decoration: underline dotted;
            text-decoration: underline dotted
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-size: inherit;
            font-weight: inherit
        }

        a {
            color: inherit;
            text-decoration: inherit
        }

        b,
        strong {
            font-weight: bolder
        }

        code,
        kbd,
        pre,
        samp {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            font-size: 1em
        }

        small {
            font-size: 80%
        }

        sub,
        sup {
            font-size: 75%;
            line-height: 0;
            position: relative;
            vertical-align: baseline
        }

        sub {
            bottom: -.25em
        }

        sup {
            top: -.5em
        }

        table {
            text-indent: 0;
            border-color: inherit;
            border-collapse: collapse
        }

        button,
        input,
        optgroup,
        select,
        textarea {
            font-family: inherit;
            font-size: 100%;
            font-weight: inherit;
            line-height: inherit;
            color: inherit;
            margin: 0;
            padding: 0
        }

        button,
        select {
            text-transform: none
        }

        [type=button],
        [type=reset],
        [type=submit],
        button {
            -webkit-appearance: button;
            background-color: transparent;
            background-image: none
        }

        :-moz-focusring {
            outline: auto
        }

        :-moz-ui-invalid {
            box-shadow: none
        }

        progress {
            vertical-align: baseline
        }

        ::-webkit-inner-spin-button,
        ::-webkit-outer-spin-button {
            height: auto
        }

        [type=search] {
            -webkit-appearance: textfield;
            outline-offset: -2px
        }

        ::-webkit-search-decoration {
            -webkit-appearance: none
        }

        ::-webkit-file-upload-button {
            -webkit-appearance: button;
            font: inherit
        }

        summary {
            display: list-item
        }

        blockquote,
        dd,
        dl,
        figure,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        hr,
        p,
        pre {
            margin: 0
        }

        fieldset {
            margin: 0;
            padding: 0
        }

        legend {
            padding: 0
        }

        menu,
        ol,
        ul {
            list-style: none;
            margin: 0;
            padding: 0
        }

        textarea {
            resize: vertical
        }

        input::placeholder,
        textarea::placeholder {
            opacity: 1;
            color: #9ca3af
        }

        [role=button],
        button {
            cursor: pointer
        }

        :disabled {
            cursor: default
        }

        audio,
        canvas,
        embed,
        iframe,
        img,
        object,
        svg,
        video {
            display: block;
            vertical-align: middle
        }

        img,
        video {
            max-width: 100%;
            height: auto
        }

        [hidden] {
            display: none
        }

        *,
        ::before,
        ::after {
            --tw-border-spacing-x: 0;
            --tw-border-spacing-y: 0;
            --tw-translate-x: 0;
            --tw-translate-y: 0;
            --tw-rotate: 0;
            --tw-skew-x: 0;
            --tw-skew-y: 0;
            --tw-scale-x: 1;
            --tw-scale-y: 1;
            --tw-pan-x: ;
            --tw-pan-y: ;
            --tw-pinch-zoom: ;
            --tw-scroll-snap-strictness: proximity;
            --tw-ordinal: ;
            --tw-slashed-zero: ;
            --tw-numeric-figure: ;
            --tw-numeric-spacing: ;
            --tw-numeric-fraction: ;
            --tw-ring-inset: ;
            --tw-ring-offset-width: 0px;
            --tw-ring-offset-color: #fff;
            --tw-ring-color: rgb(59 130 246 / 0.5);
            --tw-ring-offset-shadow: 0 0 #0000;
            --tw-ring-shadow: 0 0 #0000;
            --tw-shadow: 0 0 #0000;
            --tw-shadow-colored: 0 0 #0000;
            --tw-blur: ;
            --tw-brightness: ;
            --tw-contrast: ;
            --tw-grayscale: ;
            --tw-hue-rotate: ;
            --tw-invert: ;
            --tw-saturate: ;
            --tw-sepia: ;
            --tw-drop-shadow: ;
            --tw-backdrop-blur: ;
            --tw-backdrop-brightness: ;
            --tw-backdrop-contrast: ;
            --tw-backdrop-grayscale: ;
            --tw-backdrop-hue-rotate: ;
            --tw-backdrop-invert: ;
            --tw-backdrop-opacity: ;
            --tw-backdrop-saturate: ;
            --tw-backdrop-sepia:
        }

        ::-webkit-backdrop {
            --tw-border-spacing-x: 0;
            --tw-border-spacing-y: 0;
            --tw-translate-x: 0;
            --tw-translate-y: 0;
            --tw-rotate: 0;
            --tw-skew-x: 0;
            --tw-skew-y: 0;
            --tw-scale-x: 1;
            --tw-scale-y: 1;
            --tw-pan-x: ;
            --tw-pan-y: ;
            --tw-pinch-zoom: ;
            --tw-scroll-snap-strictness: proximity;
            --tw-ordinal: ;
            --tw-slashed-zero: ;
            --tw-numeric-figure: ;
            --tw-numeric-spacing: ;
            --tw-numeric-fraction: ;
            --tw-ring-inset: ;
            --tw-ring-offset-width: 0px;
            --tw-ring-offset-color: #fff;
            --tw-ring-color: rgb(59 130 246 / 0.5);
            --tw-ring-offset-shadow: 0 0 #0000;
            --tw-ring-shadow: 0 0 #0000;
            --tw-shadow: 0 0 #0000;
            --tw-shadow-colored: 0 0 #0000;
            --tw-blur: ;
            --tw-brightness: ;
            --tw-contrast: ;
            --tw-grayscale: ;
            --tw-hue-rotate: ;
            --tw-invert: ;
            --tw-saturate: ;
            --tw-sepia: ;
            --tw-drop-shadow: ;
            --tw-backdrop-blur: ;
            --tw-backdrop-brightness: ;
            --tw-backdrop-contrast: ;
            --tw-backdrop-grayscale: ;
            --tw-backdrop-hue-rotate: ;
            --tw-backdrop-invert: ;
            --tw-backdrop-opacity: ;
            --tw-backdrop-saturate: ;
            --tw-backdrop-sepia:
        }

        ::backdrop {
            --tw-border-spacing-x: 0;
            --tw-border-spacing-y: 0;
            --tw-translate-x: 0;
            --tw-translate-y: 0;
            --tw-rotate: 0;
            --tw-skew-x: 0;
            --tw-skew-y: 0;
            --tw-scale-x: 1;
            --tw-scale-y: 1;
            --tw-pan-x: ;
            --tw-pan-y: ;
            --tw-pinch-zoom: ;
            --tw-scroll-snap-strictness: proximity;
            --tw-ordinal: ;
            --tw-slashed-zero: ;
            --tw-numeric-figure: ;
            --tw-numeric-spacing: ;
            --tw-numeric-fraction: ;
            --tw-ring-inset: ;
            --tw-ring-offset-width: 0px;
            --tw-ring-offset-color: #fff;
            --tw-ring-color: rgb(59 130 246 / 0.5);
            --tw-ring-offset-shadow: 0 0 #0000;
            --tw-ring-shadow: 0 0 #0000;
            --tw-shadow: 0 0 #0000;
            --tw-shadow-colored: 0 0 #0000;
            --tw-blur: ;
            --tw-brightness: ;
            --tw-contrast: ;
            --tw-grayscale: ;
            --tw-hue-rotate: ;
            --tw-invert: ;
            --tw-saturate: ;
            --tw-sepia: ;
            --tw-drop-shadow: ;
            --tw-backdrop-blur: ;
            --tw-backdrop-brightness: ;
            --tw-backdrop-contrast: ;
            --tw-backdrop-grayscale: ;
            --tw-backdrop-hue-rotate: ;
            --tw-backdrop-invert: ;
            --tw-backdrop-opacity: ;
            --tw-backdrop-saturate: ;
            --tw-backdrop-sepia:
        }

        .relative {
            position: relative
        }

        .mx-auto {
            margin-left: auto;
            margin-right: auto
        }

        .mx-6 {
            margin-left: 1.5rem;
            margin-right: 1.5rem
        }

        .ml-4 {
            margin-left: 1rem
        }

        .mt-16 {
            margin-top: 4rem
        }

        .mt-6 {
            margin-top: 1.5rem
        }

        .mt-4 {
            margin-top: 1rem
        }

        .-mt-px {
            margin-top: -1px
        }

        .mr-1 {
            margin-right: 0.25rem
        }

        .flex {
            display: flex
        }

        .inline-flex {
            display: inline-flex
        }

        .grid {
            display: grid
        }

        .h-16 {
            height: 4rem
        }

        .h-7 {
            height: 1.75rem
        }

        .h-6 {
            height: 1.5rem
        }

        .h-5 {
            height: 1.25rem
        }

        .min-h-screen {
            min-height: 100vh
        }

        .w-auto {
            width: auto
        }

        .w-16 {
            width: 4rem
        }

        .w-7 {
            width: 1.75rem
        }

        .w-6 {
            width: 1.5rem
        }

        .w-5 {
            width: 1.25rem
        }

        .max-w-7xl {
            max-width: 80rem
        }

        .shrink-0 {
            flex-shrink: 0
        }

        .scale-100 {
            --tw-scale-x: 1;
            --tw-scale-y: 1;
            transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))
        }

        .grid-cols-1 {
            grid-template-columns: repeat(1, minmax(0, 1fr))
        }

        .items-center {
            align-items: center
        }

        .justify-center {
            justify-content: center
        }

        .gap-6 {
            gap: 1.5rem
        }

        .gap-4 {
            gap: 1rem
        }

        .self-center {
            align-self: center
        }

        .rounded-lg {
            border-radius: 0.5rem
        }

        .rounded-full {
            border-radius: 9999px
        }

        .bg-gray-100 {
            --tw-bg-opacity: 1;
            background-color: rgb(243 244 246 / var(--tw-bg-opacity))
        }

        .bg-white {
            --tw-bg-opacity: 1;
            background-color: rgb(255 255 255 / var(--tw-bg-opacity))
        }

        .bg-red-50 {
            --tw-bg-opacity: 1;
            background-color: rgb(254 242 242 / var(--tw-bg-opacity))
        }

        .bg-dots-darker {
            background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E")
        }

        .from-gray-700\/50 {
            --tw-gradient-from: rgb(55 65 81 / 0.5);
            --tw-gradient-to: rgb(55 65 81 / 0);
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to)
        }

        .via-transparent {
            --tw-gradient-to: rgb(0 0 0 / 0);
            --tw-gradient-stops: var(--tw-gradient-from), transparent, var(--tw-gradient-to)
        }

        .bg-center {
            background-position: center
        }

        .stroke-red-500 {
            stroke: #ef4444
        }

        .stroke-gray-400 {
            stroke: #9ca3af
        }

        .p-6 {
            padding: 1.5rem
        }

        .px-6 {
            padding-left: 1.5rem;
            padding-right: 1.5rem
        }

        .text-center {
            text-align: center
        }

        .text-right {
            text-align: right
        }

        .text-xl {
            font-size: 1.25rem;
            line-height: 1.75rem
        }

        .text-sm {
            font-size: 0.875rem;
            line-height: 1.25rem
        }

        .font-semibold {
            font-weight: 600
        }

        .leading-relaxed {
            line-height: 1.625
        }

        .text-gray-600 {
            --tw-text-opacity: 1;
            color: rgb(75 85 99 / var(--tw-text-opacity))
        }

        .text-gray-900 {
            --tw-text-opacity: 1;
            color: rgb(17 24 39 / var(--tw-text-opacity))
        }

        .text-gray-500 {
            --tw-text-opacity: 1;
            color: rgb(107 114 128 / var(--tw-text-opacity))
        }

        .underline {
            -webkit-text-decoration-line: underline;
            text-decoration-line: underline
        }

        .antialiased {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale
        }

        .shadow-2xl {
            --tw-shadow: 0 25px 50px -12px rgb(0 0 0 / 0.25);
            --tw-shadow-colored: 0 25px 50px -12px var(--tw-shadow-color);
            box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)
        }

        .shadow-gray-500\/20 {
            --tw-shadow-color: rgb(107 114 128 / 0.2);
            --tw-shadow: var(--tw-shadow-colored)
        }

        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms
        }

        .selection\:bg-red-500 *::selection {
            --tw-bg-opacity: 1;
            background-color: rgb(239 68 68 / var(--tw-bg-opacity))
        }

        .selection\:text-white *::selection {
            --tw-text-opacity: 1;
            color: rgb(255 255 255 / var(--tw-text-opacity))
        }

        .selection\:bg-red-500::selection {
            --tw-bg-opacity: 1;
            background-color: rgb(239 68 68 / var(--tw-bg-opacity))
        }

        .selection\:text-white::selection {
            --tw-text-opacity: 1;
            color: rgb(255 255 255 / var(--tw-text-opacity))
        }

        .hover\:text-gray-900:hover {
            --tw-text-opacity: 1;
            color: rgb(17 24 39 / var(--tw-text-opacity))
        }

        .hover\:text-gray-700:hover {
            --tw-text-opacity: 1;
            color: rgb(55 65 81 / var(--tw-text-opacity))
        }

        .focus\:rounded-sm:focus {
            border-radius: 0.125rem
        }

        .focus\:outline:focus {
            outline-style: solid
        }

        .focus\:outline-2:focus {
            outline-width: 2px
        }

        .focus\:outline-red-500:focus {
            outline-color: #ef4444
        }

        .group:hover .group-hover\:stroke-gray-600 {
            stroke: #4b5563
        }

        @media (prefers-reduced-motion: no-preference) {
            .motion-safe\:hover\:scale-\[1\.01\]:hover {
                --tw-scale-x: 1.01;
                --tw-scale-y: 1.01;
                transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))
            }
        }

        @media (prefers-color-scheme: dark) {
            .dark\:bg-gray-900 {
                --tw-bg-opacity: 1;
                background-color: rgb(17 24 39 / var(--tw-bg-opacity))
            }

            .dark\:bg-gray-800\/50 {
                background-color: rgb(31 41 55 / 0.5)
            }

            .dark\:bg-red-800\/20 {
                background-color: rgb(153 27 27 / 0.2)
            }

            .dark\:bg-dots-lighter {
                background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E")
            }

            .dark\:bg-gradient-to-bl {
                background-image: linear-gradient(to bottom left, var(--tw-gradient-stops))
            }

            .dark\:stroke-gray-600 {
                stroke: #4b5563
            }

            .dark\:text-gray-400 {
                --tw-text-opacity: 1;
                color: rgb(156 163 175 / var(--tw-text-opacity))
            }

            .dark\:text-white {
                --tw-text-opacity: 1;
                color: rgb(255 255 255 / var(--tw-text-opacity))
            }

            .dark\:shadow-none {
                --tw-shadow: 0 0 #0000;
                --tw-shadow-colored: 0 0 #0000;
                box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)
            }

            .dark\:ring-1 {
                --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
                --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(1px + var(--tw-ring-offset-width)) var(--tw-ring-color);
                box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000)
            }

            .dark\:ring-inset {
                --tw-ring-inset: inset
            }

            .dark\:ring-white\/5 {
                --tw-ring-color: rgb(255 255 255 / 0.05)
            }

            .dark\:hover\:text-white:hover {
                --tw-text-opacity: 1;
                color: rgb(255 255 255 / var(--tw-text-opacity))
            }

            .group:hover .dark\:group-hover\:stroke-gray-400 {
                stroke: #9ca3af
            }
        }

        @media (min-width: 640px) {
            .sm\:fixed {
                position: fixed
            }

            .sm\:top-0 {
                top: 0px
            }

            .sm\:right-0 {
                right: 0px
            }

            .sm\:ml-0 {
                margin-left: 0px
            }

            .sm\:flex {
                display: flex
            }

            .sm\:items-center {
                align-items: center
            }

            .sm\:justify-center {
                justify-content: center
            }

            .sm\:justify-between {
                justify-content: space-between
            }

            .sm\:text-left {
                text-align: left
            }

            .sm\:text-right {
                text-align: right
            }
        }

        @media (min-width: 768px) {
            .md\:grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr))
            }
        }

        @media (min-width: 1024px) {
            .lg\:gap-8 {
                gap: 2rem
            }

            .lg\:p-8 {
                padding: 2rem
            }
        }

        [x-cloak] {
            display: none !important;
        }
    </style>

</head>

<body class="font-[figtree] bg-gray-50 text-gray-800">

    <!-- NAV -->
    <header x-data="{ open: false }"
        class="fixed top-0 left-0 w-full bg-white/80 backdrop-blur-md border-b border-gray-200 z-50">

        <div class="max-w-7xl mx-auto flex items-center justify-between px-4 sm:px-6 py-4">

            <!-- LOGO -->
            <a href="#home" class="flex items-center gap-3 shrink-0">

                <div
                    class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-700 flex items-center justify-center text-white font-bold shadow-lg">
                    <img src="{{ asset('img/logo.png') }}" class="w-full h-full object-cover">

                </div>

                <div>
                    <div class="font-bold text-lg text-gray-800 tracking-wide">
                        CV Nisrina Jaya
                    </div>

                    <div class="text-xs text-gray-500 hidden sm:block">
                        Air Conditioning Specialist
                    </div>
                </div>

            </a>

            <!-- DESKTOP MENU -->
            <nav class="hidden md:flex items-center gap-8 text-sm font-medium">

                <a href="#home" class="text-gray-600 hover:text-emerald-600 transition duration-200 relative group">
                    Home
                    <span
                        class="absolute left-0 -bottom-1 w-0 h-[2px] bg-emerald-600 transition-all duration-300 group-hover:w-full"></span>
                </a>

                <a href="#about" class="text-gray-600 hover:text-emerald-600 transition duration-200 relative group">
                    About Us
                    <span
                        class="absolute left-0 -bottom-1 w-0 h-[2px] bg-emerald-600 transition-all duration-300 group-hover:w-full"></span>
                </a>

                <a href="#services" class="text-gray-600 hover:text-emerald-600 transition duration-200 relative group">
                    Services
                    <span
                        class="absolute left-0 -bottom-1 w-0 h-[2px] bg-emerald-600 transition-all duration-300 group-hover:w-full"></span>
                </a>

                <a href="#contact" class="text-gray-600 hover:text-emerald-600 transition duration-200 relative group">
                    Contact
                    <span
                        class="absolute left-0 -bottom-1 w-0 h-[2px] bg-emerald-600 transition-all duration-300 group-hover:w-full"></span>
                </a>

                <a href="#location" class="text-gray-600 hover:text-emerald-600 transition duration-200 relative group">
                    Lokasi
                    <span
                        class="absolute left-0 -bottom-1 w-0 h-[2px] bg-emerald-600 transition-all duration-300 group-hover:w-full">
                    </span>
                </a>
            </nav>

            <!-- DESKTOP AUTH -->
            <div class="hidden md:flex items-center gap-3">

                @auth

                    @if (auth()->user()->hasRole('admin'))
                        <a href="{{ route('admin.dashboard') }}"
                            class="text-sm font-medium text-gray-700 hover:text-emerald-600 transition">
                            Dashboard
                        </a>
                    @elseif(auth()->user()->hasRole('customer'))
                        <a href="{{ route('customer.dashboard') }}"
                            class="text-sm font-medium text-gray-700 hover:text-emerald-600 transition">
                            Akun Saya
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                        class="text-sm font-medium text-gray-600 hover:text-emerald-600 transition">
                        Login
                    </a>

                    <a href="{{ route('register') }}"
                        class="px-5 py-2 text-sm font-semibold bg-emerald-600 text-white rounded-xl
                    hover:bg-emerald-700 transition shadow-sm hover:shadow-lg">
                        Register
                    </a>

                @endauth

            </div>

            <!-- MOBILE BUTTON -->
            <button @click="open = !open" class="md:hidden p-2 rounded-lg text-gray-700 hover:bg-gray-100 transition">

                <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>

                <svg x-show="open" x-cloak xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>

            </button>

        </div>

        <!-- MOBILE MENU -->
        <div x-show="open" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-3" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-3" x-cloak
            class="md:hidden bg-white border-t border-gray-100 shadow-lg">

            <div class="px-4 py-4 space-y-2">

                <a href="#home" @click="open=false"
                    class="block px-4 py-3 rounded-xl hover:bg-emerald-50 hover:text-emerald-600 transition">
                    Home
                </a>

                <a href="#about" @click="open=false"
                    class="block px-4 py-3 rounded-xl hover:bg-emerald-50 hover:text-emerald-600 transition">
                    About Us
                </a>

                <a href="#services" @click="open=false"
                    class="block px-4 py-3 rounded-xl hover:bg-emerald-50 hover:text-emerald-600 transition">
                    Services
                </a>

                <a href="#contact" @click="open=false"
                    class="block px-4 py-3 rounded-xl hover:bg-emerald-50 hover:text-emerald-600 transition">
                    Contact
                </a>

                <div class="border-t pt-4 mt-4">

                    @auth

                        @if (auth()->user()->hasRole('admin'))
                            <a href="{{ route('admin.dashboard') }}"
                                class="block w-full text-center px-4 py-3 rounded-xl bg-emerald-600 text-white font-semibold">
                                Dashboard
                            </a>
                        @elseif(auth()->user()->hasRole('customer'))
                            <a href="{{ route('customer.dashboard') }}"
                                class="block w-full text-center px-4 py-3 rounded-xl bg-emerald-600 text-white font-semibold">
                                Akun Saya
                            </a>
                        @endif
                    @else
                        <div class="flex flex-col gap-3">

                            <a href="{{ route('login') }}"
                                class="block text-center px-4 py-3 rounded-xl border border-gray-300 hover:bg-gray-50 transition">
                                Login
                            </a>

                            <a href="{{ route('register') }}"
                                class="block text-center px-4 py-3 rounded-xl bg-emerald-600 text-white font-semibold hover:bg-emerald-700 transition">
                                Register
                            </a>

                        </div>

                    @endauth

                </div>

            </div>

        </div>

    </header>

    <!-- HERO -->
    <section class="pt-32 pb-20 bg-gradient-to-br from-blue-600 via-sky-500 to-cyan-500 text-white">
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-10 items-center">

            <!-- TEXT -->
            <div>
                <h1 class="text-4xl md:text-5xl font-bold leading-tight">
                    Jasa Service & Cleaning AC Profesional
                </h1>

                <p class="mt-4 text-white/90">
                    Layanan cuci AC, perawatan, isi freon, dan perbaikan AC rumah & kantor dengan teknisi berpengalaman.
                </p>

                <div class="mt-6 flex gap-4">
                    <a href="#services"
                        class="px-6 py-3 bg-white text-blue-600 rounded-lg font-semibold hover:bg-gray-100">
                        Lihat Layanan
                    </a>
                    <a href="#contact" class="px-6 py-3 border border-white rounded-lg hover:bg-white/10">
                        Hubungi Teknisi
                    </a>
                </div>
            </div>

            <!-- IMAGE CAROUSEL -->
            <div x-data="{
                active: 0,
                images: [
                    '{{ asset('gambar/img1.jpg') }}',
                    '{{ asset('gambar/img2.jpg') }}',
                    '{{ asset('gambar/img3.jpg') }}',
                    '{{ asset('gambar/img4.jpg') }}'
                ],

                init() {
                    setInterval(() => {
                        this.active = (this.active + 1) % this.images.length;
                    }, 4000);
                }
            }" class="relative">

                <!-- Images -->
                <template x-for="(image, index) in images" :key="index">

                    <img :src="image" x-show="active === index"
                        x-transition:enter="transition ease-out duration-1000"
                        x-transition:enter-start="opacity-0 scale-105" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-700" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="rounded-3xl shadow-2xl object-cover w-full h-[420px] absolute inset-0">

                </template>

                <!-- Placeholder Height -->
                <div class="h-[420px]"></div>

                <!-- Badge -->
                <div
                    class="absolute bottom-5 left-5 bg-white/95 backdrop-blur text-gray-800 px-5 py-3 rounded-2xl shadow-xl">

                    <div class="font-semibold">
                        ❄️ Professional AC Service
                    </div>

                    <div class="text-xs text-gray-500">
                        Fast • Clean • Trusted
                    </div>

                </div>

                <!-- Dots -->
                <div class="absolute bottom-5 right-5 flex gap-2">

                    <template x-for="(image, index) in images">

                        <button @click="active=index"
                            :class="active === index ?
                                'w-8 bg-white' :
                                'w-3 bg-white/50'"
                            class="h-3 rounded-full transition-all duration-300">
                        </button>

                    </template>

                </div>
                <div
                    class="absolute inset-0 rounded-3xl bg-gradient-to-t from-black/20 via-transparent to-transparent">
                </div>

            </div>

        </div>
    </section>

    <!-- ABOUT US -->
    <section id="about" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">

            <div class="grid lg:grid-cols-2 gap-12 items-center">

                <!-- IMAGE -->
                <div class="relative">

                    <img src="{{ asset('gambar/img4.jpg') }}"
                        class="rounded-3xl shadow-xl w-full h-[500px] object-cover" alt="Workshop">

                    <div class="absolute -bottom-6 -right-6 bg-emerald-600 text-white p-6 rounded-2xl shadow-xl">
                        <div class="text-3xl font-bold">
                            10+
                        </div>
                        <div class="text-sm opacity-90">
                            Tahun Pengalaman
                        </div>
                    </div>

                </div>

                <!-- CONTENT -->
                <div>

                    <span
                        class="inline-block px-4 py-2 bg-emerald-100 text-emerald-700 rounded-full text-sm font-semibold">
                        Tentang Perusahaan
                    </span>

                    <h2 class="mt-5 text-4xl font-bold text-gray-900">
                        Solusi Service & Perawatan AC Profesional
                    </h2>

                    <p class="mt-6 text-gray-600 leading-relaxed">
                        CV Nisrina Jaya merupakan perusahaan yang bergerak di bidang
                        service, perawatan, instalasi, dan perbaikan AC untuk rumah,
                        perkantoran, toko, serta industri.
                    </p>

                    <p class="mt-4 text-gray-600 leading-relaxed">
                        Dengan teknisi berpengalaman dan peralatan modern, kami
                        berkomitmen memberikan layanan yang cepat, transparan,
                        profesional, dan bergaransi.
                    </p>

                    <!-- FEATURES -->
                    <div class="grid sm:grid-cols-2 gap-4 mt-8">

                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center">
                                ✓
                            </div>
                            <div>
                                <h4 class="font-semibold">
                                    Teknisi Berpengalaman
                                </h4>
                                <p class="text-sm text-gray-500">
                                    Ditangani tenaga ahli profesional.
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center">
                                ✓
                            </div>
                            <div>
                                <h4 class="font-semibold">
                                    Harga Transparan
                                </h4>
                                <p class="text-sm text-gray-500">
                                    Tanpa biaya tersembunyi.
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center">
                                ✓
                            </div>
                            <div>
                                <h4 class="font-semibold">
                                    Bergaransi
                                </h4>
                                <p class="text-sm text-gray-500">
                                    Garansi untuk setiap pekerjaan.
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center">
                                ✓
                            </div>
                            <div>
                                <h4 class="font-semibold">
                                    Respon Cepat
                                </h4>
                                <p class="text-sm text-gray-500">
                                    Siap melayani setiap hari.
                                </p>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </section>

    <!-- COMPANY STATS -->
    <section class="py-20 bg-gray-50">

        <div class="max-w-7xl mx-auto px-4 sm:px-6">

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">

                <!-- Pelanggan -->
                <div x-data="counter(1000)" x-init="start()"
                    class="bg-white rounded-3xl p-8 text-center border border-gray-100
shadow-sm hover:shadow-2xl hover:-translate-y-2
transition-all duration-500">

                    <div
                        class="text-4xl font-extrabold bg-gradient-to-r from-emerald-500 to-emerald-700 bg-clip-text text-transparent">
                        <span x-text="count"></span>+
                    </div>

                    <p class="mt-2 text-gray-500">
                        Pelanggan
                    </p>

                </div>

                <!-- Pengalaman -->
                <div x-data="counter(10)" x-init="start()"
                    class="bg-white rounded-3xl p-8 text-center border border-gray-100
shadow-sm hover:shadow-2xl hover:-translate-y-2
transition-all duration-500">

                    <div
                        class="text-4xl font-extrabold bg-gradient-to-r from-emerald-500 to-emerald-700 bg-clip-text text-transparent">
                        <span x-text="count"></span>+
                    </div>

                    <p class="mt-2 text-gray-500">
                        Tahun Pengalaman
                    </p>

                </div>

                <!-- Teknisi -->
                <div x-data="counter(15)" x-init="start()"
                    class="bg-white rounded-3xl p-8 text-center border border-gray-100
shadow-sm hover:shadow-2xl hover:-translate-y-2
transition-all duration-500">

                    <div
                        class="text-4xl font-extrabold bg-gradient-to-r from-emerald-500 to-emerald-700 bg-clip-text text-transparent">
                        <span x-text="count"></span>+
                    </div>

                    <p class="mt-2 text-gray-500">
                        Teknisi Ahli
                    </p>

                </div>

                <!-- Support -->
                <div
                    class="bg-white rounded-3xl p-8 text-center border border-gray-100
shadow-sm hover:shadow-2xl hover:-translate-y-2
transition-all duration-500">

                    <div
                        class="text-4xl font-extrabold bg-gradient-to-r from-emerald-500 to-emerald-700 bg-clip-text text-transparent">
                        24/7
                    </div>

                    <p class="mt-2 text-gray-500">
                        Support Service
                    </p>

                </div>

            </div>

        </div>

    </section>

    <!-- WHY CHOOSE US -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6">

            <div class="text-center mb-16">
                <span
                    class="inline-block px-4 py-2 bg-emerald-100 text-emerald-700 rounded-full text-sm font-semibold">
                    Keunggulan Kami
                </span>

                <h2 class="mt-4 text-4xl font-bold">
                    Mengapa Memilih CV Nisrina Jaya?
                </h2>

                <p class="mt-4 text-gray-500 max-w-2xl mx-auto">
                    Memberikan layanan AC yang cepat, profesional,
                    transparan dan bergaransi untuk rumah,
                    kantor, toko maupun industri.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">

                <div class="bg-gray-50 p-8 rounded-3xl hover:shadow-xl transition">
                    <div class="text-4xl mb-4">🛠️</div>
                    <h3 class="font-bold text-lg">
                        Teknisi Bersertifikat
                    </h3>
                    <p class="text-gray-500 mt-3 text-sm">
                        Dikerjakan oleh teknisi berpengalaman dan terlatih.
                    </p>
                </div>

                <div class="bg-gray-50 p-8 rounded-3xl hover:shadow-xl transition">
                    <div class="text-4xl mb-4">⚡</div>
                    <h3 class="font-bold text-lg">
                        Respon Cepat
                    </h3>
                    <p class="text-gray-500 mt-3 text-sm">
                        Penanganan cepat untuk kebutuhan service mendesak.
                    </p>
                </div>

                <div class="bg-gray-50 p-8 rounded-3xl hover:shadow-xl transition">
                    <div class="text-4xl mb-4">💰</div>
                    <h3 class="font-bold text-lg">
                        Harga Transparan
                    </h3>
                    <p class="text-gray-500 mt-3 text-sm">
                        Tanpa biaya tersembunyi dan sesuai kebutuhan.
                    </p>
                </div>

                <div class="bg-gray-50 p-8 rounded-3xl hover:shadow-xl transition">
                    <div class="text-4xl mb-4">✅</div>
                    <h3 class="font-bold text-lg">
                        Bergaransi
                    </h3>
                    <p class="text-gray-500 mt-3 text-sm">
                        Setiap pekerjaan dilengkapi garansi layanan.
                    </p>
                </div>

            </div>

        </div>
    </section>

    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">

            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold">
                    Dipercaya Berbagai Perusahaan
                </h2>

                <p class="text-gray-500 mt-2">
                    Beberapa klien yang telah menggunakan layanan kami
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-5 gap-8 items-center opacity-70">

                <img src="{{ asset('logo/logo6.jpg') }}">
                <img src="{{ asset('logo/logo2.png') }}">
                <img src="{{ asset('logo/logo3.png') }}">
                <img src="{{ asset('logo/logo4.png') }}">
                <img src="{{ asset('logo/logo5.png') }}">

            </div>

        </div>
    </section>

    <!-- SERVICES -->
    <section id="services" class="py-20">
        <div class="max-w-7xl mx-auto px-6">

            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold">Layanan Kami</h2>
                <p class="text-gray-500 mt-2">Solusi lengkap perawatan AC rumah & kantor</p>
            </div>

            <div class="grid md:grid-cols-3 gap-6">

                <!-- CLEANING -->
                <div class="bg-white rounded-2xl overflow-hidden shadow hover:shadow-xl transition">
                    <img src="{{ asset('gambar/img4.jpg') }}" class="h-48 w-full object-cover">
                    <div class="p-6">
                        <h3 class="font-semibold text-lg">Cuci AC</h3>
                        <p class="text-gray-500 text-sm mt-2">
                            Membersihkan indoor & outdoor AC agar dingin maksimal.
                        </p>
                    </div>
                </div>

                <!-- FREON -->
                <div class="bg-white rounded-2xl overflow-hidden shadow hover:shadow-xl transition">
                    <img src="{{ asset('gambar/img4.jpg') }}" class="h-48 w-full object-cover">
                    <div class="p-6">
                        <h3 class="font-semibold text-lg">Isi & Tambah Freon</h3>
                        <p class="text-gray-500 text-sm mt-2">
                            Pengisian freon untuk menjaga performa pendinginan.
                        </p>
                    </div>
                </div>

                <!-- REPAIR -->
                <div class="bg-white rounded-2xl overflow-hidden shadow hover:shadow-xl transition">
                    <img src="{{ asset('gambar/img4.jpg') }}" class="h-48 w-full object-cover">
                    <div class="p-6">
                        <h3 class="font-semibold text-lg">Perbaikan AC</h3>
                        <p class="text-gray-500 text-sm mt-2">
                            Perbaikan kerusakan AC rumah, kantor, dan industri.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- WORKFLOW -->
    <section class="py-24 bg-white">

        <div class="max-w-7xl mx-auto px-6">

            <div class="text-center mb-16">

                <span
                    class="inline-block px-4 py-2 bg-emerald-100 text-emerald-700 rounded-full text-sm font-semibold">
                    Cara Kerja
                </span>

                <h2 class="mt-4 text-4xl font-bold">
                    Proses Layanan Kami
                </h2>

                <p class="mt-3 text-gray-500">
                    Mudah, cepat dan transparan
                </p>

            </div>

            <div class="grid md:grid-cols-4 gap-8">

                <div class="bg-gray-50 rounded-3xl p-8 text-center hover:shadow-xl transition">

                    <div
                        class="w-16 h-16 mx-auto rounded-full bg-emerald-100 flex items-center justify-center text-2xl font-bold text-emerald-600">
                        1
                    </div>

                    <h3 class="mt-5 font-bold">
                        Hubungi Kami
                    </h3>

                    <p class="mt-2 text-sm text-gray-500">
                        Hubungi via WhatsApp atau form website.
                    </p>

                </div>

                <div class="bg-gray-50 rounded-3xl p-8 text-center hover:shadow-xl transition">

                    <div
                        class="w-16 h-16 mx-auto rounded-full bg-emerald-100 flex items-center justify-center text-2xl font-bold text-emerald-600">
                        2
                    </div>

                    <h3 class="mt-5 font-bold">
                        Survey & Diagnosa
                    </h3>

                    <p class="mt-2 text-sm text-gray-500">
                        Teknisi melakukan pengecekan kondisi AC.
                    </p>

                </div>

                <div class="bg-gray-50 rounded-3xl p-8 text-center hover:shadow-xl transition">

                    <div
                        class="w-16 h-16 mx-auto rounded-full bg-emerald-100 flex items-center justify-center text-2xl font-bold text-emerald-600">
                        3
                    </div>

                    <h3 class="mt-5 font-bold">
                        Pengerjaan
                    </h3>

                    <p class="mt-2 text-sm text-gray-500">
                        Service dilakukan oleh teknisi profesional.
                    </p>

                </div>

                <div class="bg-gray-50 rounded-3xl p-8 text-center hover:shadow-xl transition">

                    <div
                        class="w-16 h-16 mx-auto rounded-full bg-emerald-100 flex items-center justify-center text-2xl font-bold text-emerald-600">
                        4
                    </div>

                    <h3 class="mt-5 font-bold">
                        Garansi
                    </h3>

                    <p class="mt-2 text-sm text-gray-500">
                        Pekerjaan selesai dengan garansi layanan.
                    </p>

                </div>

            </div>

        </div>

    </section>

    <section class="py-20 bg-gray-100">
        <div class="max-w-7xl mx-auto px-6 text-center">

            <h2 class="text-3xl font-bold">Hasil Pekerjaan Kami</h2>
            <p class="text-gray-500 mt-2">Perbedaan sebelum & sesudah cleaning AC</p>

            <div class="grid md:grid-cols-2 gap-6 mt-10">

                <div class="bg-white p-4 rounded-2xl shadow">
                    <img src="{{ asset('gambar/img4.jpg') }}" class="rounded-xl">
                    <p class="mt-3 font-semibold text-red-500">Sebelum Cleaning</p>
                </div>

                <div class="bg-white p-4 rounded-2xl shadow">
                    <img src="{{ asset('gambar/img5.jpg') }}" class="rounded-xl">
                    <p class="mt-3 font-semibold text-emerald-600">Sesudah Cleaning</p>
                </div>

            </div>

        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">

            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold">Workshop Kami</h2>
                <p class="text-gray-500 mt-2">Suasana kerja dan proses service kami</p>
            </div>

            <div class="grid md:grid-cols-3 gap-4">

                <img src="{{ asset('gambar/img1.jpg') }}"
                    class="rounded-2xl h-64 object-cover hover:scale-105 transition">
                <img src="{{ asset('gambar/img2.jpg') }}"
                    class="rounded-2xl h-64 object-cover hover:scale-105 transition">
                <img src="{{ asset('gambar/img4.jpg') }}"
                    class="rounded-2xl h-64 object-cover hover:scale-105 transition">

            </div>

        </div>
    </section>

    <!-- TESTIMONIAL -->
    <section class="py-24 bg-white">

        <div class="max-w-7xl mx-auto px-6">

            <!-- TITLE -->
            <div class="text-center mb-14">

                <span
                    class="inline-block px-4 py-2 bg-emerald-100 text-emerald-700 rounded-full text-sm font-semibold">
                    Testimoni Pelanggan
                </span>

                <h2 class="mt-4 text-4xl font-bold">
                    Apa Kata Pelanggan Kami?
                </h2>

                <p class="mt-3 text-gray-500 max-w-2xl mx-auto">
                    Kepuasan pelanggan adalah prioritas utama CV Nisrina Jaya.
                </p>

            </div>

            <!-- CAROUSEL -->
            <div x-data="{
                active: 0,

                testimonials: [

                    {
                        name: 'Budi Santoso',
                        position: 'Pemilik Rumah',
                        photo: '{{ asset('profile/profile1.jpg') }}',
                        text: 'Pelayanan sangat cepat dan hasil cleaning AC benar-benar memuaskan. AC menjadi lebih dingin dan bersih.'
                    },

                    {
                        name: 'Andi Wijaya',
                        position: 'Manager Kantor',
                        photo: '{{ asset('profile/profile2.jpg') }}',
                        text: 'Teknisi profesional, datang tepat waktu, dan harga sangat transparan. Sangat direkomendasikan.'
                    },

                    {
                        name: 'Rina Putri',
                        position: 'Customer',
                        photo: '{{ asset('profile/profile3.jpg') }}',
                        text: 'Sudah beberapa kali menggunakan jasa CV Nisrina Jaya dan selalu puas dengan hasil pekerjaannya.'
                    },

                    {
                        name: 'Hendra Saputra',
                        position: 'Owner Cafe',
                        photo: '{{ asset('profile/profile1.jpg') }}',
                        text: 'Perawatan AC untuk cafe kami dilakukan dengan sangat rapi dan profesional.'
                    }

                ],

                init() {
                    setInterval(() => {
                        this.active = (this.active + 1) % this.testimonials.length;
                    }, 5000);
                }
            }">

                <div class="relative overflow-hidden">

                    <!-- ITEM -->
                    <template x-for="(item,index) in testimonials" :key="index">

                        <div x-show="active === index" x-transition:enter="transition ease-out duration-700"
                            x-transition:enter-start="opacity-0 translate-x-10"
                            x-transition:enter-end="opacity-100 translate-x-0"
                            x-transition:leave="transition ease-in duration-500"
                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                            class="max-w-4xl mx-auto">

                            <div
                                class="bg-gradient-to-br from-white to-gray-50 border border-gray-100 rounded-3xl p-10 shadow-xl text-center">

                                <!-- FOTO -->
                                <img :src="item.photo"
                                    class="w-24 h-24 rounded-full mx-auto object-cover border-4 border-emerald-100">

                                <!-- RATING -->
                                <div class="mt-5 text-yellow-400 text-xl">
                                    ⭐⭐⭐⭐⭐
                                </div>

                                <!-- TESTI -->
                                <p class="mt-6 text-lg text-gray-600 leading-relaxed italic"
                                    x-text="'“' + item.text + '”'">
                                </p>

                                <!-- USER -->
                                <div class="mt-8">

                                    <h4 class="font-bold text-xl" x-text="item.name">
                                    </h4>

                                    <p class="text-gray-500" x-text="item.position">
                                    </p>

                                </div>

                            </div>

                        </div>

                    </template>

                    <!-- PREV -->
                    <button @click="active = active === 0 ? testimonials.length - 1 : active - 1"
                        class="absolute left-0 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white shadow-lg hover:shadow-xl">

                        ←

                    </button>

                    <!-- NEXT -->
                    <button @click="active = (active + 1) % testimonials.length"
                        class="absolute right-0 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white shadow-lg hover:shadow-xl">

                        →

                    </button>

                </div>

                <!-- DOTS -->
                <div class="flex justify-center gap-3 mt-8">

                    <template x-for="(item,index) in testimonials">

                        <button @click="active=index"
                            :class="active === index ?
                                'w-8 bg-emerald-600' :
                                'w-3 bg-gray-300'"
                            class="h-3 rounded-full transition-all duration-300">
                        </button>

                    </template>

                </div>

            </div>

        </div>

    </section>

    <!-- FAQ -->
    <section class="py-24 bg-gray-50">

        <div class="max-w-4xl mx-auto px-6">

            <div class="text-center mb-14">

                <span
                    class="inline-block px-4 py-2 bg-emerald-100 text-emerald-700 rounded-full text-sm font-semibold">
                    FAQ
                </span>

                <h2 class="mt-4 text-4xl font-bold">
                    Pertanyaan Umum
                </h2>

            </div>

            <div x-data="{ open: 1 }" class="space-y-4">

                <template
                    x-for="item in [
                {
                    id:1,
                    q:'Berapa biaya cuci AC?',
                    a:'Biaya menyesuaikan kapasitas dan kondisi AC.'
                },
                {
                    id:2,
                    q:'Apakah ada garansi?',
                    a:'Ya, setiap pekerjaan mendapatkan garansi layanan.'
                },
                {
                    id:3,
                    q:'Apakah melayani perusahaan?',
                    a:'Kami melayani rumah, kantor, toko dan industri.'
                }
            ]">

                    <div class="bg-white rounded-2xl border">

                        <button @click="open = open === item.id ? null : item.id"
                            class="w-full flex justify-between items-center p-6">

                            <span class="font-semibold" x-text="item.q"></span>

                            <span x-text="open===item.id ? '-' : '+'"></span>

                        </button>

                        <div x-show="open===item.id" x-transition class="px-6 pb-6 text-gray-500">

                            <p x-text="item.a"></p>

                        </div>

                    </div>

                </template>

            </div>

        </div>

    </section>

    <!-- LOCATION -->
    <section id="location" class="py-24 bg-white">

        <div class="max-w-7xl mx-auto px-6">

            <div class="text-center mb-12">

                <span
                    class="inline-block px-4 py-2 bg-emerald-100 text-emerald-700 rounded-full text-sm font-semibold">
                    Lokasi Kami
                </span>

                <h2 class="mt-4 text-4xl font-bold">
                    Kantor & Workshop
                </h2>

                <p class="mt-3 text-gray-500">
                    Kunjungi workshop kami atau hubungi teknisi untuk layanan di lokasi Anda.
                </p>

            </div>

            <div class="overflow-hidden rounded-3xl shadow-2xl">

                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d8631.873906666211!2d112.75331056542068!3d-7.271348720688595!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sid!2sid!4v1782177372142!5m2!1sid!2sid"
                    width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>

            </div>

        </div>

    </section>

    <!-- CONTACT US -->
    <section id="contact" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">

            <!-- TITLE -->
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800">Contact Us</h2>
                <p class="text-gray-500 mt-2">
                    Kami siap membantu Anda kapan saja. Silakan hubungi kami.
                </p>
            </div>

            <!-- GRID -->
            <div class="grid md:grid-cols-2 gap-10">

                <!-- INFO -->
                <div class="space-y-6">

                    <div class="bg-white p-6 rounded-2xl shadow-sm border">
                        <h3 class="font-semibold text-gray-800">📍 Alamat</h3>
                        <p class="text-gray-600 mt-1">Surabaya, Jawa Timur</p>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border">
                        <h3 class="font-semibold text-gray-800">📞 Telepon</h3>
                        <p class="text-gray-600 mt-1">0812-3456-7890</p>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border">
                        <h3 class="font-semibold text-gray-800">✉️ Email</h3>
                        <p class="text-gray-600 mt-1">support@servicepro.com</p>
                    </div>

                    <a href="https://wa.me/6281234567890"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-green-500 text-white rounded-xl hover:bg-green-600 transition">
                        💬 Chat WhatsApp
                    </a>

                </div>

                <!-- FORM -->
                <div class="bg-white p-8 rounded-2xl shadow-sm border">

                    <form>

                        <div class="mb-4">
                            <label class="text-sm text-gray-600">Nama</label>
                            <input type="text"
                                class="w-full mt-1 px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                placeholder="Nama Anda">
                        </div>

                        <div class="mb-4">
                            <label class="text-sm text-gray-600">Email</label>
                            <input type="email"
                                class="w-full mt-1 px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                placeholder="email@gmail.com">
                        </div>

                        <div class="mb-4">
                            <label class="text-sm text-gray-600">Pesan</label>
                            <textarea rows="4"
                                class="w-full mt-1 px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                placeholder="Tulis pesan Anda..."></textarea>
                        </div>

                        <button type="submit"
                            class="w-full bg-emerald-600 text-white py-3 rounded-lg font-semibold hover:bg-emerald-700 transition">
                            Kirim Pesan
                        </button>

                    </form>

                </div>

            </div>

        </div>
    </section>

    <section class="py-24 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white">
        <div class="max-w-5xl mx-auto px-6 text-center">

            <h2 class="text-4xl font-bold">
                Butuh Service AC Profesional?
            </h2>

            <p class="mt-4 text-white/80">
                Hubungi tim CV Nisrina Jaya sekarang dan dapatkan layanan cepat,
                bergaransi, serta ditangani teknisi berpengalaman.
            </p>

            <div class="mt-8 flex justify-center gap-4 flex-wrap">

                <a href="https://wa.me/6281234567890"
                    class="px-8 py-4 bg-white text-emerald-700 rounded-2xl font-bold hover:scale-105 transition">
                    WhatsApp Sekarang
                </a>

                <a href="#contact" class="px-8 py-4 border border-white rounded-2xl hover:bg-white/10 transition">
                    Hubungi Kami
                </a>

            </div>

        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-gray-900 text-gray-300">

        <div class="max-w-7xl mx-auto px-6 py-16">

            <div class="grid md:grid-cols-4 gap-10">

                <div>

                    <h3 class="text-xl font-bold text-white">
                        CV Nisrina Jaya
                    </h3>

                    <p class="mt-4 text-sm text-gray-400">
                        Spesialis service, perawatan dan instalasi AC
                        profesional untuk rumah dan perusahaan.
                    </p>

                </div>

                <div>

                    <h4 class="font-semibold text-white mb-4">
                        Menu
                    </h4>

                    <div class="space-y-2">

                        <a href="#home" class="block hover:text-white">
                            Home
                        </a>

                        <a href="#about" class="block hover:text-white">
                            About
                        </a>

                        <a href="#services" class="block hover:text-white">
                            Services
                        </a>

                    </div>

                </div>

                <div>

                    <h4 class="font-semibold text-white mb-4">
                        Kontak
                    </h4>

                    <p>📞 0812-3456-7890</p>
                    <p>✉️ support@nisrinajaya.com</p>
                    <p>📍 Surabaya</p>

                </div>

                <div>

                    <h4 class="font-semibold text-white mb-4">
                        Jam Operasional
                    </h4>

                    <p>Senin - Sabtu</p>
                    <p>08.00 - 17.00 WIB</p>

                </div>

            </div>

            <div class="border-t border-gray-800 mt-10 pt-6 text-center">

                © {{ date('Y') }} CV Nisrina Jaya.
                All Rights Reserved.

            </div>

        </div>

    </footer>

    <!-- FLOATING WA -->
    <a href="https://wa.me/6281234567890" target="_blank" class="fixed bottom-6 right-6 z-50">

        <div
            class="w-16 h-16 rounded-full bg-green-500
        hover:bg-green-600 text-white
        flex items-center justify-center
        shadow-2xl hover:scale-110 transition-all duration-300">

            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">

                <path d="M20.52 3.48A11.82 11.82 0 0 0 1.86 17.8L.5 23.5l5.83-1.31A11.82 11.82 0 1 0 20.52 3.48z" />

            </svg>

        </div>

    </a>

    <script>
        function counter(target) {
            return {
                count: 0,

                start() {

                    const observer = new IntersectionObserver((entries) => {

                        if (entries[0].isIntersecting) {

                            let duration = 2000;
                            let stepTime = Math.max(
                                Math.floor(duration / target),
                                10
                            );

                            let interval = setInterval(() => {

                                if (this.count < target) {

                                    this.count += Math.ceil(target / 100);

                                    if (this.count > target) {
                                        this.count = target;
                                    }

                                } else {
                                    clearInterval(interval);
                                }

                            }, stepTime);

                            observer.disconnect();
                        }

                    });

                    observer.observe(this.$el);
                }
            }
        }
    </script>

    <script>
        AOS.init({
            duration: 900,
            once: true,
            offset: 100
        });
    </script>


</body>

</html>
