<aside id="sidebar"
    class="hs-overlay hs-overlay-open:translate-x-0 -translate-x-full transition-all duration-300 transform fixed top-0 start-0 bottom-0 z-[60] w-64 bg-white border-e border-gray-200 flex flex-col pt-7 pb-10 overflow-hidden lg:block lg:translate-x-0 lg:end-auto lg:bottom-0">
    <div class="px-6 pb-8">
        <a class="flex-none text-xl font-bold inline-flex items-center gap-x-2" href="{{ route('landing') }}">
            <img src="{{ asset('logo_app.png') }}" alt="Logo" class="size-8 object-contain">
            <div>
                <span class="text-gray-900 leading-none block font-heading">StageFlow</span>
                <span class="text-[10px] font-medium text-indigo-600 uppercase tracking-widest">Admin</span>
            </div>
        </a>
    </div>
    
    <div class="px-4 mb-6">
        <div class="bg-gradient-to-br from-indigo-50 to-indigo-50 border border-indigo-100 rounded-xl p-3 flex items-center gap-3">
            <div class="shrink-0 size-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-sm">AD</div>
            <div class="min-w-0">
                <p class="text-sm font-bold text-gray-800 truncate">Admin Principal</p>
                <p class="text-[11px] text-indigo-600 font-medium">Super Administrateur</p>
            </div>
        </div>
    </div>

    <nav class="flex-1 px-4 w-full flex flex-col flex-wrap overflow-y-auto">
        <ul class="space-y-1.5">
            <li>
                <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}" href="{{ route('admin.dashboard') }}">
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <rect width="7" height="9" x="3" y="3" rx="1" />
                        <rect width="7" height="5" x="14" y="3" rx="1" />
                        <rect width="7" height="9" x="14" y="12" rx="1" />
                        <rect width="7" height="5" x="3" y="16" rx="1" />
                    </svg>
                    Tableau de bord
                </a>
            </li>
            <li>
                <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm rounded-lg {{ request()->routeIs('admin.users.*') ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}" href="{{ route('admin.users.index') }}">
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                    Utilisateurs
                </a>
            </li>
            <li>
                <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm rounded-lg {{ request()->routeIs('admin.feedbacks.*') ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}" href="{{ route('admin.feedbacks.index') }}">
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                    </svg>
                    Feedbacks
                </a>
            </li>
        </ul>
    </nav>
    <div class="px-4 mt-auto">
        <div class="h-px bg-gray-100 mb-4 mx-2"></div>
        <a class="flex items-center gap-x-3.5 py-2.5 px-2.5 text-sm font-semibold text-red-600 rounded-lg hover:bg-red-50 transition" href="#">
            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path d="m16 17 5-5-5-5" />
                <path d="M21 12H9" />
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
            </svg>
            Déconnexion
        </a>
    </div>
</aside>
