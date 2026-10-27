<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Alveral')</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo/link_logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
   
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak] { display: none !important; }</style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brandBlue: '#0ea5e9',
                        brandDark: '#1e293b',
                        brandOrange: '#f97316'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-white min-h-screen text-gray-900 antialiased flex flex-col justify-between" x-data="{ mobileMenu: false, mobileCatOpen: false }">

    <nav class="bg-white/95 backdrop-blur-md border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-8 h-20 flex justify-between items-center">
            
            <a href="{{ url('/') }}" class="flex items-center">
                <img src="{{ asset('img/logo/logo.png') }}" alt="Alveral" class="h-12 sm:h-12 w-auto object-contain">
            </a>

            <div class="hidden md:flex items-center space-x-10 text-sm font-medium tracking-wide text-gray-700">
                <a href="{{ url('/') }}" class="text-brandOrange font-semibold transition">Anasayfa</a>
                
                <div class="relative" x-data="{ catOpen: false }">
                    <button @click="catOpen = !catOpen" @click.away="catOpen = false" type="button" class="flex items-center gap-1.5 hover:text-brandOrange transition focus:outline-none">
                        Kategoriler
                        <svg class="w-4 h-4 transition-transform duration-200" :class="catOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    
                    <div x-show="catOpen" x-cloak 
                         x-transition:enter="transition ease-out duration-200" 
                         x-transition:enter-start="opacity-0 translate-y-2" 
                         x-transition:enter-end="opacity-100 translate-y-0" 
                         class="absolute left-0 mt-4 w-60 bg-white border border-gray-100 rounded-2xl shadow-2xl py-3 z-50">
                        <a href="{{ url('/') }}" class="block px-5 py-2.5 text-xs uppercase tracking-wider font-bold text-gray-800 hover:bg-gray-50 hover:text-brandOrange transition">Tüm Ürünler</a>
                        @foreach($categories as $cat)
                            <a href="{{ url('/?category=' . $cat->slug) }}" class="block px-5 py-2.5 text-xs font-medium text-gray-600 hover:bg-gray-50 hover:text-brandOrange transition">
                                {{ $cat->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <a href="{{ route('contact') }}" class="hover:text-brandOrange transition">İletişim</a>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ route('admin.dashboard') }}" class="hidden sm:inline-flex bg-gray-900 text-white hover:bg-brandOrange px-5 py-2.5 rounded-full text-xs font-semibold uppercase tracking-wider transition">Yönetim Paneli</a>
                
                <button x-on:click="mobileMenu = !mobileMenu" type="button" class="md:hidden p-2 text-gray-700 rounded-xl focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>
        </div>

        <div x-show="mobileMenu" x-cloak class="md:hidden bg-white border-b border-gray-100 px-6 py-5 space-y-4 shadow-xl">
            <a href="{{ url('/') }}" class="block text-sm font-medium text-gray-700">Anasayfa</a>
            
            <div>
                <button x-on:click="mobileCatOpen = !mobileCatOpen" type="button" class="w-full flex justify-between items-center text-xs font-extrabold text-gray-400 uppercase tracking-widest pt-2 focus:outline-none">
                    <span>Kategoriler</span>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="mobileCatOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                
                <div x-show="mobileCatOpen" x-cloak class="pl-3 mt-3 space-y-2.5 border-l-2 border-orange-100 max-h-48 overflow-y-auto">
                    <a href="{{ url('/') }}" class="block text-xs font-semibold text-gray-800">Tüm Ürünler</a>
                    @if(isset($categories))
                        @foreach($categories as $cat)
                            <a href="{{ url('/?category=' . $cat->slug) }}" class="block text-xs text-gray-600 hover:text-brandOrange transition">{{ $cat->name }}</a>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="pt-2">
                <a href="{{ route('contact') }}" class="block text-sm font-bold text-brandOrange">İletişim</a>
            </div>
            <div class="pt-2">
                <a href="{{ route('admin.dashboard') }}" class="block text-center bg-gray-900 text-white py-3 rounded-full text-xs font-bold uppercase tracking-wider">Yönetim Paneli</a>
            </div>
        </div>
    </nav>

    <main class="flex-1">
        @yield('content')
    </main>

    <footer id="iletisim" class="bg-gray-900 text-white py-16 px-6 mt-24">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-10 text-sm">
            <div>
                <img src="{{ asset('img/logo/logo.png') }}" alt="Alveral" class="h-12 w-auto mb-4 brightness-120">
                <p class="text-gray-400 font-light leading-relaxed">Özenle seçilmiş ürünleri ve en avantajlı fırsatları modern vitrin konseptiyle buluşturuyoruz.</p>
            </div>
            <div>
                <h3 class="font-bold text-xs uppercase tracking-widest mb-4 text-white">Keşfet</h3>
                <ul class="space-y-2 text-gray-400 font-light">
                    <li><a href="{{ url('/') }}" class="hover:text-white transition">Anasayfa</a></li>
                    <li><a href="{{ route('admin.dashboard') }}" class="hover:text-white transition">Yönetim Paneli</a></li>
                </ul>
            </div>
            <div>
                <h3 class="font-bold text-xs uppercase tracking-widest mb-4 text-white">İletişim</h3>
                <p class="text-gray-400 font-light">Destek ve işbirliği için:</p>
                <p class="text-brandOrange font-bold mt-1">iletisim@alveral.com</p>
            </div>
        </div>
        <div class="border-t border-gray-800 mt-12 pt-8 flex flex-col items-center justify-center text-center text-sm text-gray-400 font-light">
            <p>© {{ date('Y') }} Alveral. Tüm hakları saklıdır.</p>
            <a href="https://edaoncel.github.io/edaoncell/project.html" target="_blank" rel="noopener noreferrer" class="mt-4 hover:text-white transition duration-300 flex items-center gap-2 group">
                <span class="text-gray-300">Alveral Tasarım & Geliştirme:</span>
                <span class="font-bold text-white underline underline-offset-4 decoration-brandOrange group-hover:text-brandOrange transition tracking-wider">Eda Öncel</span>
            </a>
        </div>
    </footer>

</body>
</html>