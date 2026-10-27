@extends('layouts.admin')

@section('title', 'Alveral - Yönetim Paneli')

@section('content')
<div class="max-w-6xl mx-auto space-y-10">
    
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-900 px-6 py-4 rounded-2xl flex justify-between items-center shadow-sm" x-data="{ show: true }" x-show="show">
            <div class="flex items-center gap-3">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 shrink-0"></span>
                <span class="text-xs font-bold tracking-wide">{{ session('success') }}</span>
            </div>
            <button @click="show = false" class="text-emerald-700 hover:text-emerald-900 text-xs font-black">✕</button>
        </div>
    @endif

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 pb-6 border-b border-slate-100">
        <div>
            <span class="text-[10px] text-brandOrange font-black uppercase tracking-widest">Alveral Kontrol Merkezi</span>
            <h1 class="text-3xl font-black text-gray-900 mt-1 tracking-tight">Hoş Geldiniz, {{ Auth::guard('admin')->user()?->name ?? 'Yönetici' }}</h1>
            <p class="text-gray-500 text-xs sm:text-sm font-light mt-1">Platformun ürünlerini, gelen mesajları ve kategorileri buradan yönetin.</p>
        </div>

        <div class="bg-gray-50 border border-gray-100 text-gray-800 px-5 py-3 rounded-2xl flex items-center gap-3 shadow-sm w-full md:w-auto">
            <span class="flex h-2.5 w-2.5 relative">
              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brandOrange opacity-75"></span>
              <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-brandOrange"></span>
            </span>
            <div class="text-xs">
                <span class="font-bold block uppercase tracking-wider text-gray-900">Sistem Aktif</span>
                <span class="text-gray-500 font-light">Tüm veri akışları senkronize.</span>
            </div>
        </div>
    </div>

    

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
    
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between hover:border-brandOrange transition group">
        <div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider group-hover:text-brandOrange transition">Toplam Ürün</span>
            <h2 class="text-3xl font-black text-gray-900 mt-1">{{ $productsCount }}</h2>
        </div>
        <div class="w-12 h-12 rounded-xl bg-orange-50 text-brandOrange flex items-center justify-center group-hover:scale-105 transition shadow-sm">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between hover:border-blue-500 transition group">
        <div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider group-hover:text-blue-600 transition">Kategoriler</span>
            <h2 class="text-3xl font-black text-gray-900 mt-1">{{ $categories->count() }}</h2>
        </div>
        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center group-hover:scale-105 transition shadow-sm">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
            </svg>
        </div>
    </div>

    <a href="{{ route('admin.messages.index') }}" class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between hover:border-purple-500 transition group">
        <div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider group-hover:text-purple-600 transition">Yeni Mesajlar</span>
            <div class="flex items-baseline gap-2 mt-1">
                <h2 class="text-3xl font-black text-gray-900">{{ $unreadMessagesCount }}</h2>
                @if($unreadMessagesCount > 0)
                    <span class="text-[10px] font-bold text-white bg-rose-500 px-2 py-0.5 rounded-full animate-pulse">Yeni</span>
                @else
                    <span class="text-[10px] font-bold text-slate-400 bg-slate-50 px-2 py-0.5 rounded-full">Okundu</span>
                @endif
            </div>
        </div>
        <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center group-hover:scale-105 transition shadow-sm">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
        </div>
    </a>

    <a href="{{ route('admin.visitors') }}" class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between hover:border-emerald-500 transition group">
        <div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider group-hover:text-emerald-600 transition">Ziyaretçiler</span>
            <div class="flex items-baseline gap-2 mt-1">
                <h2 class="text-3xl font-black text-gray-900">{{ $totalVisitors }}</h2>
                <span class="text-[10px] text-emerald-600 font-bold bg-emerald-50 px-2 py-0.5 rounded-full">+{{ $todayVisitors ?? 0 }} bugün</span>
            </div>
        </div>
        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:scale-105 transition shadow-sm">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
            </svg>
        </div>
    </a>

</div>

<div class="bg-white border border-slate-200 p-6 sm:p-10 rounded-3xl shadow-sm mt-6">
    <div class="flex justify-between items-center mb-6 border-b border-slate-100 pb-4">
        <div>
            <span class="text-[10px] text-brandOrange font-black uppercase tracking-widest">Görsel Analiz</span>
            <h3 class="text-xl font-black text-gray-900 mt-0.5">Kategori Halka Grafiği</h3>
        </div>
        <span class="text-xs text-slate-400 font-bold uppercase tracking-wider">Canlı Dağılım</span>
    </div>

    @if(isset($categories) && count($categories) > 0)
        @php
            $colors = ['#ff6600', '#3b82f6', '#8b5cf6', '#10b981', '#f43f5e', '#f59e0b', '#6366f1', '#06b6d4'];
            $totalProd = $categories->sum('products_count');
            $currentDegree = 0;
            $gradientStops = [];

            if ($totalProd > 0) {
                foreach($categories as $index => $cat) {
                    $count = $cat->products_count ?? 0;
                    $angle = ($count / $totalProd) * 360;
                    $nextDegree = $currentDegree + $angle;
                    $color = $colors[$index % count($colors)];
                    $gradientStops[] = "{$color} {$currentDegree}deg {$nextDegree}deg";
                    $currentDegree = $nextDegree;
                }
            }
            $gradientString = count($gradientStops) > 0 ? implode(', ', $gradientStops) : '#e2e8f0 0deg 360deg';
        @endphp

        <div class="flex flex-col md:flex-row items-center justify-center gap-8 py-4">
            
            <div class="relative w-52 h-52 rounded-full shadow-inner shrink-0" style="background: conic-gradient({{ $gradientString }});">
                <div class="absolute inset-8 bg-white rounded-full flex flex-col items-center justify-center shadow-sm">
                    <span class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">Toplam Ürün</span>
                    <span class="text-2xl font-black text-gray-900">{{ $totalProd }}</span>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 w-full max-w-md">
                @foreach($categories as $index => $cat)
                    @php
                        $pCount = $cat->products_count ?? 0;
                        $pct = $totalProd > 0 ? round(($pCount / $totalProd) * 100, 1) : 0;
                        $dotColor = $colors[$index % count($colors)];
                    @endphp
                    <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100">
                        <div class="flex items-center gap-2.5 overflow-hidden">
                            <span class="w-3 h-3 rounded-full shrink-0" style="background-color: {{ $dotColor }};"></span>
                            <span class="text-xs font-bold text-slate-700 truncate">{{ $cat->name }}</span>
                        </div>
                        <span class="text-xs font-black text-slate-500 shrink-0 ml-2">%{{ $pct }} <span class="text-[10px] text-slate-400 font-normal">({{ $pCount }})</span></span>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="text-center py-8 text-slate-400 text-sm">
            Grafik oluşturulacak kategori verisi bulunamadı.
        </div>
    @endif
</div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white border border-slate-100 p-8 rounded-3xl shadow-sm hover:border-brandOrange/40 transition flex flex-col justify-between group">
            <div>
                <span class="text-[10px] text-brandOrange uppercase font-black tracking-widest block mb-3">Modül 01</span>
                <h3 class="text-xl font-black text-gray-900 mb-2 group-hover:text-brandOrange transition">Ürün Yönetimi</h3>
                <p class="text-xs text-gray-500 leading-relaxed font-light">Lookbook sergilenen en çok satan ürünleri, fiyatları ve görselleri düzenleyin.</p>
            </div>
            <div class="mt-8 pt-4 border-t border-slate-100 flex justify-between items-center">
                <span class="text-[11px] font-bold text-slate-400">Aktif</span>
                <a href="{{ route('products.index') }}" class="text-xs bg-gray-900 text-white group-hover:bg-brandOrange px-5 py-2.5 rounded-full font-bold transition uppercase tracking-wider">Yönet →</a>
            </div>
        </div>

        <div class="bg-white border border-slate-100 p-8 rounded-3xl shadow-sm hover:border-brandOrange/40 transition flex flex-col justify-between group">
            <div>
                <span class="text-[10px] text-brandOrange uppercase font-black tracking-widest block mb-3">Modül 02</span>
                <h3 class="text-xl font-black text-gray-900 mb-2 group-hover:text-brandOrange transition">Kategori Yönetimi</h3>
                <p class="text-xs text-gray-500 leading-relaxed font-light">Vitrin kategorilerini yapılandırın ve filtreleme başlıklarını güncelleyin.</p>
            </div>
            <div class="mt-8 pt-4 border-t border-slate-100 flex justify-between items-center">
                <span class="text-[11px] font-bold text-slate-400">Aktif</span>
                <a href="{{ route('categories.index') }}" class="text-xs bg-gray-900 text-white group-hover:bg-brandOrange px-5 py-2.5 rounded-full font-bold transition uppercase tracking-wider">Yönet →</a>
            </div>
        </div>

        <div class="bg-white border border-slate-100 p-8 rounded-3xl shadow-sm hover:border-brandOrange/40 transition flex flex-col justify-between group">
            <div>
                <span class="text-[10px] text-brandOrange uppercase font-black tracking-widest block mb-3">Modül 03</span>
                <h3 class="text-xl font-black text-gray-900 mb-2 group-hover:text-brandOrange transition">Yönetici Listesi</h3>
                <p class="text-xs text-gray-500 leading-relaxed font-light">Ortakların erişim yetkilerini kontrol edin ve yeni ortak hesapları tanımlayın.</p>
            </div>
            <div class="mt-8 pt-4 border-t border-slate-100 flex justify-between items-center">
                <span class="text-[11px] font-bold text-slate-400">Ortak Alanı</span>
                <a href="{{ route('admin.admins.index') }}" class="text-xs bg-gray-900 text-white group-hover:bg-brandOrange px-5 py-2.5 rounded-full font-bold transition uppercase tracking-wider">Yönet →</a>
            </div>
        </div>
    </div>
</div>
@endsection