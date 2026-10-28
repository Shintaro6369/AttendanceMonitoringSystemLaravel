<!DOCTYPE html>
<html lang="en" id="html-root">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Monitoring System</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Moving background orb animations */
        @keyframes floatSlow {
            0%, 100% { transform: translate(0px, 0px) scale(1); }
            50% { transform: translate(30px, -40px) scale(1.1); }
        }
        @keyframes floatFast {
            0%, 100% { transform: translate(0px, 0px) scale(1); }
            50% { transform: translate(-30px, 30px) scale(0.95); }
        }
        .animate-blob-1 { animation: floatSlow 8s ease-in-out infinite; }
        .animate-blob-2 { animation: floatFast 6s ease-in-out infinite; }

        /* Glassmorphism styling */
        .glass-panel {
            background: rgba(13, 148, 136, 0.08);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(45, 212, 191, 0.2);
        }

        /* Dyslexic friendly font style */
        .font-dyslexic { 
            font-family: 'Comic Sans MS', 'Verdana', sans-serif !important; 
            letter-spacing: 0.06em !important; 
            word-spacing: 0.1em !important;
        }

        /* Global scalable font classes */
        body.scale-sm { font-size: 13px !important; }
        body.scale-md { font-size: 16px !important; }
        body.scale-lg { font-size: 19px !important; }
        body.scale-xl { font-size: 22px !important; }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen flex flex-col relative overflow-x-hidden transition-all duration-200 scale-md" id="body-root">

    <!-- MOVING BACKGROUND ELEMENTS (TURQUOISE ORBS) -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-teal-500/20 rounded-full blur-3xl animate-blob-1"></div>
        <div class="absolute bottom-1/4 right-1/4 w-[30rem] h-[30rem] bg-cyan-500/15 rounded-full blur-3xl animate-blob-2"></div>
        <div class="absolute top-1/2 right-1/3 w-72 h-72 bg-emerald-500/15 rounded-full blur-3xl animate-blob-1" style="animation-delay: 2s;"></div>
    </div>

    <!-- Top Navigation Bar -->
    <header class="relative z-20 glass-panel border-b border-teal-500/20 px-6 py-4 flex justify-between items-center shadow-md">
        <div class="flex items-center space-x-3">
            <div class="w-9 h-9 bg-gradient-to-tr from-teal-500 to-cyan-400 rounded-lg flex items-center justify-center shadow-lg shadow-teal-500/30">
                <svg class="w-5 h-5 text-slate-950" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h1 class="font-extrabold text-lg text-white tracking-wide">AttendanceSystem</h1>
        </div>
        <div>
            <button onclick="toggleAboutModal()" class="text-xs font-semibold bg-teal-500/10 hover:bg-teal-500/20 text-teal-300 border border-teal-500/30 px-4 py-2 rounded-xl transition">About Us</button>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="relative z-10 flex-1 flex items-center justify-center py-12 px-4">
        @yield('content')
    </main>

    <!-- CIRCULAR FLOATING ACCESSIBILITY BUTTON & POP-UP MENU -->
    <div class="fixed bottom-6 right-6 z-50 flex flex-col items-end">
        <!-- Pop-up Features Menu (Hidden by default) -->
        <div id="accessibilityMenu" class="hidden mb-3 w-64 glass-panel bg-slate-900/90 border border-teal-500/30 p-4 rounded-2xl shadow-2xl flex flex-col space-y-3 transition-all transform origin-bottom-right">
            <div class="flex justify-between items-center border-b border-teal-500/20 pb-2">
                <span class="text-xs font-bold text-teal-300 uppercase tracking-wider">Accessibility Tools</span>
                <button onclick="toggleAccessibilityMenu()" class="text-slate-400 hover:text-white text-sm">&times;</button>
            </div>
            <!-- Font Size Adjusters -->
            <div class="flex items-center justify-between">
                <span class="text-xs text-slate-300">Font Size</span>
                <div class="flex space-x-1">
                    <button onclick="adjustFontSize(-1)" class="w-8 h-8 bg-teal-500/10 hover:bg-teal-500/20 text-teal-300 rounded-lg font-bold text-xs border border-teal-500/30" title="Decrease Font">A-</button>
                    <button onclick="adjustFontSize(1)" class="w-8 h-8 bg-teal-500/10 hover:bg-teal-500/20 text-teal-300 rounded-lg font-bold text-xs border border-teal-500/30" title="Increase Font">A+</button>
                </div>
            </div>
            <!-- Dyslexic Font Toggle -->
            <div class="flex items-center justify-between">
                <span class="text-xs text-slate-300">Dyslexic Font</span>
                <button onclick="toggleDyslexicFont()" id="dyslexicBtn" class="px-3 py-1 bg-teal-500/10 hover:bg-teal-500/20 text-teal-300 rounded-lg text-xs font-semibold border border-teal-500/30 transition">Enable</button>
            </div>
        </div>

        <!-- Circular Main Button -->
        <button onclick="toggleAccessibilityMenu()" class="w-14 h-14 bg-gradient-to-tr from-teal-500 to-cyan-400 text-slate-950 rounded-full shadow-lg shadow-teal-500/40 flex items-center justify-center hover:scale-105 active:scale-95 transition transform focus:outline-none" title="Accessibility Options">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
        </button>
    </div>

    <!-- About Us Modal -->
    <div id="aboutModal" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm hidden flex items-center justify-center z-50 p-4">
        <div class="glass-panel bg-slate-900 border border-teal-500/30 p-6 rounded-2xl max-w-sm w-full shadow-2xl text-left">
            <h3 class="text-base font-bold text-white mb-2">About Attendance Monitoring</h3>
            <p class="text-xs text-slate-300 mb-6 leading-relaxed">This system streamlines attendance tracking for all students across all courses efficiently, securely, and with full accessibility features.</p>
            <button onclick="toggleAboutModal()" class="w-full bg-gradient-to-r from-teal-500 to-cyan-400 hover:from-teal-400 hover:to-cyan-300 text-slate-950 font-bold py-2.5 rounded-xl text-xs transition">Close</button>
        </div>
    </div>

    <!-- JavaScript Controls -->
    <script>
        function toggleAccessibilityMenu() {
            const menu = document.getElementById('accessibilityMenu');
            menu.classList.toggle('hidden');
        }

        function toggleAboutModal() {
            document.getElementById('aboutModal').classList.toggle('hidden');
        }

        // Font scaling levels representation
        const scaleLevels = ['scale-sm', 'scale-md', 'scale-lg', 'scale-xl'];
        let currentScaleIndex = 1; // Default to scale-md

        function applyScale(index) {
            const body = document.getElementById('body-root');
            body.classList.remove(...scaleLevels);
            body.classList.add(scaleLevels[index]);
            
            // Also proportionally scale inline typography elements or scale all text elements directly
            const allTextElements = document.querySelectorAll('p, span, h1, h2, h3, h4, label, button, input, a');
            allTextElements.forEach(el => {
                if(!el.dataset.baseSize) {
                    const computedSize = window.getComputedStyle(el).fontSize;
                    el.dataset.baseSize = parseFloat(computedSize);
                }
                const multiplier = [0.85, 1.0, 1.2, 1.35][index];
                el.style.fontSize = (el.dataset.baseSize * multiplier) + 'px';
            });
        }

        function adjustFontSize(delta) {
            currentScaleIndex += delta;
            if(currentScaleIndex < 0) currentScaleIndex = 0;
            if(currentScaleIndex >= scaleLevels.length) currentScaleIndex = scaleLevels.length - 1;
            
            applyScale(currentScaleIndex);
            localStorage.setItem('accessibility_font_scale', currentScaleIndex);
        }

        function toggleDyslexicFont() {
            const body = document.getElementById('body-root');
            const btn = document.getElementById('dyslexicBtn');
            body.classList.toggle('font-dyslexic');
            
            const isDyslexic = body.classList.contains('font-dyslexic');
            if(isDyslexic) {
                btn.textContent = "Disable";
                btn.className = "px-3 py-1 bg-teal-500 text-slate-950 rounded-lg text-xs font-bold transition";
                localStorage.setItem('accessibility_dyslexic', 'true');
            } else {
                btn.textContent = "Enable";
                btn.className = "px-3 py-1 bg-teal-500/10 hover:bg-teal-500/20 text-teal-300 rounded-lg text-xs font-semibold border border-teal-500/30 transition";
                localStorage.setItem('accessibility_dyslexic', 'false');
            }
        }

        // Load saved preferences on every page load
        document.addEventListener('DOMContentLoaded', () => {
            const savedScale = localStorage.getItem('accessibility_font_scale');
            if(savedScale !== null) {
                currentScaleIndex = parseInt(savedScale);
                applyScale(currentScaleIndex);
            }

            const savedDyslexic = localStorage.getItem('accessibility_dyslexic');
            if(savedDyslexic === 'true') {
                const body = document.getElementById('body-root');
                const btn = document.getElementById('dyslexicBtn');
                body.classList.add('font-dyslexic');
                if(btn) {
                    btn.textContent = "Disable";
                    btn.className = "px-3 py-1 bg-teal-500 text-slate-950 rounded-lg text-xs font-bold transition";
                }
            }
        });
    </script>
</body>
</html>