<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification Email - StageFlow</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <script src="https://cdn.jsdelivr.net/npm/preline/dist/preline.js" defer></script>
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { 50: '#eef2ff', 100: '#e0e7ff', 200: '#c7d2fe', 300: '#a5b4fc', 400: '#818cf8', 500: '#6366f1', 600: '#4f46e5', 700: '#4338ca', 800: '#3730a3', 900: '#312e81', 950: '#1e1b4b' },
                    },
                    fontFamily: { sans: ['Inter', 'sans-serif'], heading: ['Outfit', 'sans-serif'] },
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-heading { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-[#fafbfc] min-h-full flex flex-col items-center justify-center relative overflow-x-hidden py-12">

    <!-- Background Decor -->
    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="absolute top-[-15%] left-[-10%] size-[800px] bg-gradient-to-br from-indigo-500/15 via-purple-500/10 to-transparent rounded-full blur-[140px] animate-pulse"></div>
        <div class="absolute bottom-[-15%] right-[-10%] size-[800px] bg-gradient-to-tr from-purple-500/15 via-indigo-500/10 to-transparent rounded-full blur-[140px] animate-pulse" style="animation-delay: 3s;"></div>
    </div>

    <main class="w-full max-w-md p-6 relative z-10" data-aos="zoom-in">
        <!-- Logo -->
        <div class="text-center mb-8">
            <a href="{{ route('landing') }}" class="inline-flex items-center gap-x-3 group">
                <img src="{{ asset('logo_app.png') }}" alt="Logo" class="size-10 object-contain group-hover:rotate-12 transition-transform">
                <span class="text-2xl font-black font-heading text-slate-900 tracking-tight">StageFlow</span>
            </a>
        </div>

        <!-- Auth Card -->
        <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-indigo-100/50 border border-slate-100 p-8 lg:p-10 relative overflow-hidden">
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-indigo-50/50 rounded-full blur-3xl opacity-50"></div>

            <div class="text-center mb-10 relative z-10">
                <h1 class="text-2xl font-black font-heading text-slate-900 mb-2">Vérifiez vos emails 📩</h1>
                <p class="text-xs font-medium text-slate-500">Un lien de vérification a été envoyé à votre adresse.</p>
            </div>

            @if (session('resent'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl text-emerald-600 text-xs font-bold flex items-center gap-3">
                    <svg class="size-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Un nouveau lien a été envoyé.
                </div>
            @endif

            <div class="text-sm text-slate-600 mb-8 text-center leading-relaxed">
                Avant de continuer, veuillez vérifier votre boîte de réception. Si vous n'avez pas reçu l'email, cliquez sur le bouton ci-dessous.
            </div>

            <form action="{{ route('verification.resend') }}" method="POST" class="space-y-6">
                @csrf
                <button type="submit" class="w-full py-4 px-6 inline-flex justify-center items-center gap-x-2 text-sm font-bold rounded-2xl border border-transparent bg-indigo-600 text-white hover:bg-indigo-700 shadow-xl shadow-indigo-100 transition-all hover:scale-[1.02] active:scale-[0.98]">
                    Renvoyer l'email
                </button>
            </form>
        </div>

        <div class="mt-8 text-center">
            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400">© 2026 StageFlow Maroc</p>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({ once: true, duration: 800 });
        });
    </script>
</body>
</html>
