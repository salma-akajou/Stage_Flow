<div class="rounded-2xl shadow-lg shadow-indigo-200 p-5 text-white relative overflow-hidden" 
     style="background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%) !important;"
     data-aos="fade-up" data-aos-delay="200">
    
    <div class="absolute -top-6 -right-6 size-24 bg-white opacity-10 rounded-full blur-2xl pointer-events-none"></div>
    <div class="absolute -bottom-8 -left-4 size-20 bg-white opacity-5 rounded-full blur-xl pointer-events-none"></div>
    
    <div class="relative z-10">
        <div class="flex items-center gap-2 mb-3">
            <svg class="size-5 text-white opacity-80" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
            </svg>
            <h2 class="text-sm font-bold">Donner notre avis</h2>
        </div>
        <p class="text-xs text-white opacity-80 mb-4 leading-relaxed font-medium">Partagez votre expérience avec StageFlow. Votre avis apparaîtra sur notre page d'accueil.</p>
        
        @if($errors->hasAny(['note', 'commentaire']))
            <div class="mb-4 text-xs font-bold text-rose-200 bg-rose-900/30 p-3 rounded-xl border border-rose-500/30">
                @foreach($errors->getMessages() as $field => $messages)
                    @if(in_array($field, ['note', 'commentaire']))
                        @foreach($messages as $message)
                            <p>• {{ $message }}</p>
                        @endforeach
                    @endif
                @endforeach
            </div>
        @endif

        <form action="{{ route('entreprise.feedback.store') }}" method="POST" x-data="starRating(3)">
            @csrf
            <div class="flex items-center gap-1 mb-3">
                <template x-for="i in 5">
                    <button type="button" 
                        @click="setRating(i)" 
                        class="text-2xl transition-colors duration-200 focus:outline-none"
                        :style="rating >= i ? 'color: #fde047 !important' : 'color: rgba(255,255,255,0.4) !important'">
                        ★
                    </button>
                </template>
                <input type="hidden" name="note" :value="rating" required>
            </div>
            
            <textarea name="commentaire" required
                style="background: rgba(255,255,255,0.15) !important;"
                class="w-full text-sm backdrop-blur-sm text-white placeholder-white opacity-80 border border-white opacity-30 rounded-xl p-3 resize-none focus:outline-none focus:border-white focus:bg-white opacity-20 transition"
                rows="3" placeholder="Votre retour d'expérience..."></textarea>
            
            <button type="submit"
                class="mt-3 w-full py-2.5 px-4 bg-white text-indigo-600 text-sm font-bold rounded-xl hover:bg-indigo-50 transition shadow-sm transform hover:scale-[1.01]">
                Soumettre l'avis
            </button>
        </form>
    </div>
</div>
