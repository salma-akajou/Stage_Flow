<div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl overflow-hidden min-h-[400px]">
    <div class="p-6 border-b border-gray-100 flex items-center gap-x-2">
        <h3 class="text-lg font-bold text-gray-800">Donnez votre Feedback</h3>
    </div>
    <form action="{{ route('student.feedback.store') }}" method="POST" class="p-6 flex-grow flex flex-col space-y-4">
        @csrf
        <p class="text-xs text-gray-500 font-bold lowercase">Partagez vos suggestions pour améliorer StageFlow.</p>
        
        @if($errors->hasAny(['note', 'commentaire']))
            <div class="p-4 bg-rose-50 border border-rose-200 text-rose-700 text-xs font-bold rounded-xl">
                Erreur : {{ $errors->first('commentaire') ?: $errors->first('note') }}
            </div>
        @endif

        <textarea name="commentaire" required
            class="py-3 px-4 block w-full bg-gray-50 border-gray-200 rounded-xl text-sm focus:border-indigo-600 focus:ring-0 transition-all outline-none min-h-[140px]"
            placeholder="Votre avis sur l'application..."></textarea>
        
        <div class="flex items-center gap-x-2" x-data="starRating(5)">
            <input type="hidden" name="note" x-model="rating">
            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Note :</span>
            <div class="flex space-x-1 text-yellow-400">
                @for($i = 1; $i <= 5; $i++)
                <button type="button" @click="setRating({{ $i }})" class="focus:outline-none transition-transform hover:scale-110">
                    <svg class="size-5 transition-colors" :class="rating >= {{ $i }} ? 'text-yellow-400' : 'text-gray-200'" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                </button>
                @endfor
            </div>
        </div>
        
        <div class="pt-0 mt-auto">
            <button type="submit"
                class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-xs font-bold rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition">
                Envoyer mon avis
            </button>
        </div>
    </form>
</div>
