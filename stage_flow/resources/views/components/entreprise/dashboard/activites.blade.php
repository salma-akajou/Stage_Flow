
<div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6" data-aos="fade-up" data-aos-delay="150">
    <h2 class="text-base font-bold text-gray-800 mb-5">Activité récente</h2>
    <div class="space-y-5">
        @foreach($activites as $act)
            <div class="flex gap-4">
                <div class="flex flex-col items-center">
                    <div class="size-8 rounded-full flex items-center justify-center shrink-0 
                        @if($act['type'] === 'offre') bg-blue-100 text-blue-600 
                        @elseif($act['type'] === 'candidature') bg-indigo-100 text-indigo-600 
                        @elseif($act['type'] === 'acceptation') bg-emerald-100 text-emerald-600 
                        @elseif($act['type'] === 'refus') bg-rose-100 text-rose-600 
                        @else bg-gray-100 text-gray-600 @endif">
                        
                        @if($act['type'] === 'acceptation')
                            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path d="M20 6 9 17l-5-5" /></svg>
                        @elseif($act['type'] === 'refus')
                            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path d="M18 6 6 18M6 6l12 12" /></svg>
                        @elseif($act['type'] === 'candidature')
                            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M19 11v6m-3-3h6"/></svg>
                        @else
                            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z" /></svg>
                        @endif
                    </div>
                    @if(!$loop->last)
                        <div class="w-0.5 h-full bg-gray-100 mt-2"></div>
                    @endif
                </div>
                <div class="pb-5 flex-1">
                    <p class="text-sm font-semibold text-gray-800 leading-tight">{{ $act['titre'] }}</p>
                    <p class="text-xs text-gray-500 mt-0.5 whitespace-pre-wrap leading-relaxed">{{ $act['description'] }}</p>
                    <span class="text-[10px] text-gray-400 mt-1 block uppercase font-bold italic tracking-wider">{{ $act['date']->diffForHumans() }}</span>
                </div>
            </div>
        @endforeach
    </div>
</div>
