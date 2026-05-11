@if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-center gap-4 shadow-sm" data-aos="fade-down">
        <div class="size-10 bg-emerald-500 text-white rounded-xl flex items-center justify-center shrink-0 shadow-lg shadow-emerald-100">
            <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
        </div>
        <div>
            <p class="text-sm font-black text-emerald-900 leading-none">Succès !</p>
            <p class="text-xs font-bold text-emerald-600/80 mt-1">{{ session('success') }}</p>
        </div>
    </div>
@endif

@if($errors->any() && !$errors->hasAny(['note', 'commentaire']))
    <div class="mb-6 p-4 bg-rose-50 border border-rose-200 rounded-2xl flex items-center gap-4 shadow-sm" data-aos="fade-down">
        <div class="size-10 bg-rose-500 text-white rounded-xl flex items-center justify-center shrink-0 shadow-lg shadow-rose-100">
            <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </div>
        <div class="text-xs font-bold text-rose-600">
            @foreach($errors->all() as $error)
                @if(!in_array($error, $errors->get('note')) && !in_array($error, $errors->get('commentaire')))
                    <p>{{ $error }}</p>
                @endif
            @endforeach
        </div>
    </div>
@endif
