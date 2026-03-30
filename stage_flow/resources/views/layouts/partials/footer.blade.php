<footer class="bg-slate-950 text-white py-20 relative z-10 border-t border-white/5">
    <div class="max-w-[85rem] mx-auto px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-12 mb-16">
            <div class="col-span-full lg:col-span-2">
                <a class="flex items-center gap-x-2 text-2xl font-bold font-heading mb-6" href="{{ route('landing') }}">
                    <img src="{{ asset('logo_app.png') }}" alt="Logo" class="size-10 object-contain brightness-0 invert">
                    StageFlow
                </a>
                <p class="text-slate-400 text-sm leading-relaxed max-w-sm">
                    Propulsez les talents de demain vers leur premier défi professionnel au Maroc.
                </p>
            </div>
            <div>
                <h4 class="text-xs font-bold uppercase tracking-widest text-white mb-6">Plateforme</h4>
                <ul class="space-y-4 text-sm text-slate-400">
                    <li><a href="{{ route('offres.index') }}" class="hover:text-indigo-400 transition">Recherche de stage</a></li>
                    <li><a href="#experience" class="hover:text-indigo-400 transition">L'expérience StageFlow</a></li>
                    <li><a href="{{ route('student.dashboard') }}" class="hover:text-indigo-400 transition">Profil Étudiant</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-xs font-bold uppercase tracking-widest text-white mb-6">Support</h4>
                <ul class="space-y-4 text-sm text-slate-400">
                    <li><a href="#faq" class="hover:text-indigo-400 transition">Centre d'aide (FAQ)</a></li>
                    <li><a href="#" class="hover:text-indigo-400 transition">Connexion</a></li>
                    <li><a href="#" class="hover:text-indigo-400 transition">Inscription</a></li>
                </ul>
            </div>
            <div class="col-span-full lg:col-span-1">
                <h4 class="text-xs font-bold uppercase tracking-widest text-white mb-6">Contact</h4>
                <ul class="space-y-4 text-sm text-slate-400">
                    <li class="flex items-center gap-x-3"><span class="text-indigo-500">📍</span> Maroc</li>
                    <li class="flex items-center gap-x-3"><span class="text-indigo-500">📧</span> contact@stageflow.ma</li>
                </ul>
            </div>
        </div>
        <div class="pt-8 border-t border-slate-900 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-[10px] text-slate-500 uppercase font-bold tracking-widest">© {{ date('Y') }} StageFlow Maroc. Conçu avec Excellence.</p>
            <div class="flex gap-x-6">
                <a href="#" class="text-slate-500 hover:text-white transition">
                    <svg class="size-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                </a>
                <a href="#" class="text-slate-500 hover:text-white transition">
                    <svg class="size-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.315 2c2.43 0 2.784.012 3.855.06 1.028.044 1.587.213 1.957.358.491.19.84.417 1.208.785.368.368.595.717.785 1.208.145.37.314.929.358 1.957.048 1.07.06 1.425.06 3.855s-.012 2.784-.06 3.855c-.044 1.028-.213 1.587-.358 1.957-.19.491-.417.84-.785 1.208-.368.368-.717.595-1.208.785-.37.145-.929.314-1.957.358-1.07-.048-1.425-.06-3.855-.06s-2.784-.012-3.855-.06c-1.028-.044-1.587-.213-1.957-.358-.491.19-.84.417-1.208.785-.368.368-.717.595-1.208.785-.37.145-.929.314-1.957.358-1.07-.048-1.425-.06-3.855-.06"/></svg>
                </a>
            </div>
        </div>
    </div>
</footer>
