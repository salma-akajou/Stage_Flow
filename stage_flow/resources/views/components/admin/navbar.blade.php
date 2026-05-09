<header class="sticky top-0 inset-x-0 flex flex-wrap sm:justify-start sm:flex-nowrap z-[48] w-full bg-white/90 backdrop-blur-md border-b border-gray-200 text-sm py-2.5 sm:py-4 lg:ps-64">
    <nav class="max-w-[85rem] mx-auto w-full px-4 sm:px-6 lg:px-8 flex items-center justify-between">
        <div class="flex items-center gap-x-3">
            <button type="button"
                class="lg:hidden py-2 px-3 inline-flex justify-center items-center gap-x-2 bg-white border border-gray-200 text-gray-800 text-sm font-medium rounded-lg shadow-sm hover:bg-gray-50"
                data-hs-overlay="#sidebar">
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <line x1="3" x2="21" y1="6" y2="6" />
                    <line x1="3" x2="21" y1="12" y2="12" />
                    <line x1="3" x2="21" y1="18" y2="18" />
                </svg>
            </button>
            <ol class="flex items-center whitespace-nowrap min-w-0">
                <li class="inline-flex items-center text-sm text-gray-400 hover:text-indigo-600 transition">
                    <a href="{{ route('landing') }}">StageFlow</a>
                    <svg class="shrink-0 mx-2 size-4 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path d="m9 18 6-6-6-6" />
                    </svg>
                </li>
                <li class="inline-flex items-center text-sm text-gray-400">
                    Admin
                    <svg class="shrink-0 mx-2 size-4 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path d="m9 18 6-6-6-6" />
                    </svg>
                </li>
                <li class="inline-flex items-center text-sm font-semibold text-gray-800 truncate">@yield('breadcrumb', 'Dashboard')</li>
            </ol>
        </div>
        <div class="flex items-center gap-x-2 sm:gap-x-4">
            <div class="hs-dropdown [--placement:bottom-right] relative inline-flex">
                <button type="button" class="size-9 flex justify-center items-center rounded-full border border-gray-200 bg-white shadow-sm hover:bg-gray-50 transition">
                    <div class="size-full rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs">AD</div>
                </button>
                <div class="hs-dropdown-menu hs-dropdown-open:opacity-100 w-56 opacity-0 hidden z-10 bg-white border border-gray-200 rounded-lg shadow-md p-1 mt-2">
                    <div class="py-3 px-4 -m-1 bg-indigo-50 rounded-t-lg font-medium text-gray-800 text-sm">Administrateur</div>
                    <div class="p-1 mt-2 text-sm space-y-0.5">
                        <div class="border-t my-1"></div>
                        <a class="flex items-center gap-x-3 py-2 px-3 rounded-lg hover:bg-gray-100 text-red-600" href="#">Déconnexion</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
