<footer class="bg-slate-950 text-white py-20 relative z-10 border-t border-white/5">
    <div class="max-w-[85rem] mx-auto px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-12 mb-16">
            <div class="col-span-full lg:col-span-2">
                <a class="flex items-center gap-x-2 text-2xl font-bold font-heading mb-6" href="{{ route('landing') }}" @click="activeLink = 'accueil'">
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
                    <li><a href="{{ route('offres.index') }}" @click="activeLink = 'offres'" class="hover:text-indigo-400 transition">Offres de Stage</a></li>
                    <li><a href="#experience" 
                           @click.prevent="activeLink = 'propos'; document.getElementById('experience').scrollIntoView({ behavior: 'smooth' })" 
                           class="hover:text-indigo-400 transition">À propos</a></li>
                    <li><a href="#" @click="activeLink = 'entreprises'" class="hover:text-indigo-400 transition">Entreprises</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-xs font-bold uppercase tracking-widest text-white mb-6">Support</h4>
                <ul class="space-y-4 text-sm text-slate-400">
                    <li><a href="#faq" 
                           @click.prevent="document.getElementById('faq').scrollIntoView({ behavior: 'smooth' })"
                           class="hover:text-indigo-400 transition">Centre d'aide (FAQ)</a></li>
                    <li><a href="#" class="hover:text-indigo-400 transition">Connexion</a></li>
                    <li><a href="#" class="hover:text-indigo-400 transition">Inscription</a></li>
                </ul>
            </div>
            <div class="col-span-full lg:col-span-1">
                <h4 class="text-xs font-bold uppercase tracking-widest text-white mb-6">Contact</h4>
                <ul class="space-y-4 text-sm text-slate-400">
                    <li class="flex items-center gap-x-3 transition hover:text-white"><span class="text-indigo-500">📍</span> Maroc</li>
                    <li class="flex items-center gap-x-3 transition hover:text-white"><span class="text-indigo-500">📧</span> contact@stageflow.ma</li>
                </ul>
            </div>
        </div>
        <div class="pt-8 border-t border-slate-900 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-[10px] text-slate-500 uppercase font-bold tracking-widest">© {{ date('Y') }} StageFlow Maroc. Conçu avec Excellence.</p>
            <div class="flex gap-x-6">
                <a href="https://facebook.com" target="_blank" class="text-slate-500 hover:text-white transition transform hover:scale-110">
                    <svg class="size-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                </a>
                <a href="https://instagram.com" target="_blank" class="text-slate-500 hover:text-white transition transform hover:scale-110">
                    <svg class="size-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
                </a>
                <a href="https://linkedin.com" target="_blank" class="text-slate-500 hover:text-white transition transform hover:scale-110">
                     <svg class="size-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                </a>
            </div>
        </div>
    </div>
</footer>
