@php
    $role = 'guest';
    $sid = 0;
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->hasRole('admin')) {
            $role = 'admin';
        } elseif ($user->hasRole('entreprise')) {
            $role = 'entreprise';
        } elseif ($user->hasRole('etudiant')) {
            $role = 'etudiant';
        }
        $sid = $user->id;
    }
@endphp

<div x-data="chatbotApp({ 
        messageUrl: '{{ route('chatbot.message') }}',
        role: '{{ $role }}',
        userId: {{ $sid }}
     })" 
     @click.outside="open = false; saveState();" 
     class="font-sans relative z-50">
    
    <!-- Chatbot Toggle Button -->
    <button @click="toggleOpen" 
            class="fixed bottom-6 right-6 flex items-center justify-center w-14 h-14 bg-gradient-to-tr from-indigo-600 to-violet-600 rounded-full text-white shadow-xl hover:shadow-indigo-500/30 hover:scale-105 active:scale-95 transition-all duration-300 group focus:outline-none"
            aria-label="Open AI Assistant">
        <span class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-rose-500 rounded-full animate-ping" x-show="unread"></span>
        <span class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-rose-500 rounded-full border-2 border-white" x-show="unread"></span>
        
        <!-- Chat Icon -->
        <svg x-show="!open" class="w-6 h-6 transform transition-transform duration-300 group-hover:rotate-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
        </svg>
        
        <!-- Close Icon -->
        <svg x-show="open" x-cloak class="w-6 h-6 transform transition-transform duration-300 rotate-90" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>

    <!-- Chat Window Container -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 translate-y-8 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-8 scale-95"
         x-cloak
         class="fixed bottom-24 right-6 w-[350px] sm:w-[400px] h-[520px] max-h-[calc(100vh-120px)] bg-white rounded-3xl shadow-2xl border border-slate-100 flex flex-col overflow-hidden">
        
        <!-- Header -->
        <div class="px-5 py-4 bg-gradient-to-r from-indigo-600 to-violet-600 text-white flex items-center justify-between shadow-md shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-white/15 flex items-center justify-center border border-white/10 shadow-inner">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="text-left">
                    <h3 class="font-black text-xs tracking-widest uppercase">StageFlow Assistant</h3>
                    <div class="flex items-center gap-1 mt-0.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span class="text-[9px] text-indigo-100 font-bold uppercase tracking-wider">Assistant IA en ligne</span>
                    </div>
                </div>
            </div>
            
            <div class="flex items-center gap-1">
                <!-- Clear history button -->
                <button @click="clearHistory" title="Effacer l'historique" class="text-white/80 hover:text-white transition-colors focus:outline-none p-1.5 rounded-lg hover:bg-white/10">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
                <button @click="toggleOpen" class="text-white/80 hover:text-white transition-colors focus:outline-none p-1.5 rounded-lg hover:bg-white/10">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Messages Box -->
        <div x-ref="chatBox" class="flex-1 p-4 overflow-y-auto bg-slate-50/50 space-y-4 hide-scrollbar">
            <!-- Dynamic Messages -->
            <template x-for="(msg, index) in messages" :key="index">
                <div>
                    <!-- Bot Bubble -->
                    <template x-if="msg.sender === 'bot'">
                        <div class="flex items-start gap-2.5 max-w-[85%] transition-all">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-indigo-600 to-violet-600 flex items-center justify-center text-[10px] font-black text-white shrink-0 shadow-md">
                                IA
                            </div>
                            <div :class="[
                                'border rounded-2xl rounded-tl-none p-3.5 text-xs shadow-sm transition-all leading-relaxed flex flex-col gap-3 text-left',
                                msg.success 
                                    ? 'bg-indigo-50/70 border-indigo-100 text-indigo-900 shadow-indigo-50/50' 
                                    : 'bg-white border-slate-100 text-slate-700'
                            ]">
                                <p class="whitespace-pre-line text-xs font-semibold" x-html="formatMessage(msg.text)"></p>
                                
                                <!-- Suggestions inside the welcome bubble -->
                                <template x-if="msg.options && msg.options.length">
                                    <div class="flex flex-col gap-2 pt-1">
                                        <template x-for="opt in msg.options">
                                            <button type="button" @click="useOption(opt.prompt)" class="w-full flex items-center gap-2 px-3 py-2 text-[10px] font-bold bg-slate-50 hover:bg-indigo-50 hover:text-indigo-700 text-slate-600 border border-slate-200/60 hover:border-indigo-200 rounded-xl transition-all focus:outline-none shadow-sm text-left">
                                                <!-- Icons -->
                                                <span class="text-xs" x-text="opt.icon"></span>
                                                <span x-text="opt.label"></span>
                                            </button>
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>

                    <!-- User Bubble -->
                    <template x-if="msg.sender === 'user'">
                        <div class="flex items-start gap-2.5 max-w-[85%] ms-auto justify-end transition-all">
                            <div class="bg-indigo-600 text-white rounded-2xl rounded-tr-none p-3.5 shadow-md shadow-indigo-100 text-xs font-semibold leading-relaxed text-left">
                                <p class="whitespace-pre-line" x-text="msg.text"></p>
                            </div>
                            <div class="w-8 h-8 rounded-full bg-slate-200 border border-slate-300 flex items-center justify-center text-[10px] font-black text-slate-600 shrink-0 shadow-sm">
                                ME
                            </div>
                        </div>
                    </template>
                </div>
            </template>

            <!-- Loading Indicator -->
            <div x-show="isLoading" class="flex items-start gap-2.5 max-w-[90%] text-left" x-cloak>
                <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-indigo-600 to-violet-600 flex items-center justify-center text-[10px] font-black text-white shrink-0 shadow-sm">
                    IA
                </div>
                <div class="bg-white border border-slate-100 rounded-2xl rounded-tl-none px-4 py-3 flex items-center gap-1.5 shadow-sm">
                    <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full animate-bounce" style="animation-delay: 0.1s"></span>
                    <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full animate-bounce" style="animation-delay: 0.2s"></span>
                    <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full animate-bounce" style="animation-delay: 0.3s"></span>
                </div>
            </div>
        </div>

        <!-- Input Form -->
        <form @submit.prevent="sendMessage" class="p-3 bg-white border-t border-slate-100 flex items-center gap-2 shrink-0">
            <input type="text" 
                   x-model="newMessage" 
                   :placeholder="getPlaceholder()" 
                   class="flex-1 px-4 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 placeholder-slate-400 font-medium"
                   :disabled="isLoading" />
            <button type="submit" 
                    class="p-2.5 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 active:scale-95 transition-all shadow-lg shadow-indigo-100 focus:outline-none disabled:opacity-50 shrink-0"
                    :disabled="isLoading || !newMessage.trim()">
                <svg class="w-4 h-4 transform rotate-90" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
            </button>
        </form>
    </div>
</div>
