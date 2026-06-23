<nav x-data="{ open: false }"
    class="bg-emerald-950/80 backdrop-blur
           border-b border-emerald-800/40
           sticky top-0 z-50 shadow-md">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-end h-16">

            {{-- RIGHT --}}
            <div class="flex items-center gap-3">

                {{-- Notification --}}
                <button
                    class="p-2 rounded-xl text-emerald-100
                               hover:bg-emerald-800/40 transition">
                    🔔
                </button>

                {{-- USER DROPDOWN --}}
                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">
                        <button
                            class="flex items-center gap-3 px-3 py-2 rounded-xl
                                   bg-emerald-800/30
                                   hover:bg-emerald-700/40 transition
                                   ring-1 ring-emerald-700/30">

                            <div
                                class="w-8 h-8 bg-emerald-600 text-white rounded-full
                                       flex items-center justify-center text-xs font-bold
                                       ring-1 ring-emerald-300/30">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>

                            <div class="text-left hidden sm:block leading-tight">
                                <div class="text-sm font-semibold text-emerald-100">
                                    {{ Auth::user()->name }}
                                </div>
                                <div class="text-[11px] text-emerald-300/70">
                                    {{ ucfirst(Auth::user()->roles->first()?->name ?? '-') }}
                                </div>
                            </div>

                            <svg class="h-4 w-4 text-emerald-200" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>

                        </button>
                    </x-slot>

                    <x-slot name="content"
                        class="bg-emerald-950 border border-emerald-800/40
                               rounded-xl shadow-xl overflow-hidden">

                        {{-- <x-dropdown-link :href="route('admin.profile.edit')"
                            class="text-emerald-100 hover:bg-emerald-800/40 transition px-4 py-2">
                            👤 Profile
                        </x-dropdown-link> --}}

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="text-red-400 hover:bg-red-500/10 transition px-4 py-2">
                                🚪 Log Out
                            </x-dropdown-link>
                        </form>

                    </x-slot>

                </x-dropdown>

                {{-- MOBILE BUTTON --}}
                <button @click="open = !open"
                    class="sm:hidden p-2 rounded-xl text-emerald-100
                           hover:bg-emerald-800/40 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />

                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

            </div>
        </div>
    </div>

    {{-- MOBILE MENU --}}
    <div :class="{ 'block': open, 'hidden': !open }"
        class="hidden sm:hidden border-t border-emerald-800/40
               bg-emerald-950">

        <div class="px-4 py-3 space-y-2">

            <a href="{{ route('admin.dashboard') }}"
                class="block px-4 py-2 rounded-lg text-emerald-100
                       hover:bg-emerald-800/40 transition">
                📊 Dashboard
            </a>

            {{-- <a href="{{ route('admin.profile.edit') }}"
                class="block px-4 py-2 rounded-lg text-emerald-100
                       hover:bg-emerald-800/40 transition">
                👤 Profile
            </a> --}}

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit"
                    class="w-full text-left px-4 py-2 rounded-lg text-red-400
                           hover:bg-red-500/10 transition">
                    🚪 Log Out
                </button>
            </form>

        </div>
    </div>

</nav>
