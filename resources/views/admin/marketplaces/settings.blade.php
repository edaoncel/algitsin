@extends('layouts.admin')

@section('title', 'Alveral - Pazaryeri API Ayarları')

@section('content')
<div class="max-w-6xl mx-auto space-y-8">
    
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 pb-6 border-b border-slate-200">
        <div>
            <span class="text-[10px] text-brandOrange font-black uppercase tracking-widest">Entegrasyon Yönetimi</span>
            <h1 class="text-3xl font-black text-gray-900 mt-1 tracking-tight">Pazaryeri API Ayarları</h1>
            <p class="text-gray-500 text-xs sm:text-sm font-light mt-1">Trendyol ve Hepsiburada mağaza anahtarlarınızı yapılandırın.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.marketplaces.logs') }}" class="px-5 py-2.5 bg-white border border-slate-200 hover:border-slate-300 text-gray-700 rounded-xl font-bold text-xs transition shadow-sm">
                Entegrasyon Logları →
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-900 px-6 py-4 rounded-2xl flex justify-between items-center shadow-sm" x-data="{ show: true }" x-show="show">
            <div class="flex items-center gap-3">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 shrink-0"></span>
                <span class="text-xs font-bold tracking-wide">{{ session('success') }}</span>
            </div>
            <button @click="show = false" class="text-emerald-700 hover:text-emerald-900 text-xs font-black">✕</button>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        @php
            $trendyol = $settings['trendyol'] ?? null;
        @endphp
        <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm flex flex-col justify-between">
            <form action="{{ route('admin.marketplaces.settings.update', 'trendyol') }}" method="POST" class="space-y-6">
                @csrf
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-orange-50 text-brandOrange flex items-center justify-center font-black">T</div>
                        <div>
                            <h2 class="text-lg font-black text-gray-900">Trendyol Entegrasyonu</h2>
                            <span class="text-xs text-slate-400">Supplier API Bağlantısı</span>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ optional($trendyol)->is_active ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brandOrange"></div>
                    </label>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Merchant ID (Tedarikçi ID)</label>
                        <input type="text" name="merchant_id" value="{{ old('merchant_id', optional($trendyol)->merchant_id) }}" placeholder="Örn: 123456" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:border-brandOrange transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">API Key (Kullanıcı Key)</label>
                        <input type="text" name="api_key" value="{{ old('api_key', optional($trendyol)->api_key) }}" placeholder="Trendyol API Key" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:border-brandOrange transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">API Secret (Şifre)</label>
                        <input type="password" name="api_secret" value="{{ old('api_secret', optional($trendyol)->api_secret) }}" placeholder="••••••••••••" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:border-brandOrange transition">
                    </div>
                </div>

                <button type="submit" class="w-full py-3 bg-gray-900 hover:bg-brandOrange text-white text-xs font-bold uppercase tracking-wider rounded-xl transition shadow-sm">
                    Trendyol Ayarlarını Kaydet
                </button>
            </form>
        </div>

        @php
            $hepsiburada = $settings['hepsiburada'] ?? null;
        @endphp
        <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm flex flex-col justify-between">
            <form action="{{ route('admin.marketplaces.settings.update', 'hepsiburada') }}" method="POST" class="space-y-6">
                @csrf
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-black">H</div>
                        <div>
                            <h2 class="text-lg font-black text-gray-900">Hepsiburada Entegrasyonu</h2>
                            <span class="text-xs text-slate-400">MP Merchant API Bağlantısı</span>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ optional($hepsiburada)->is_active ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Merchant ID (Mağaza ID)</label>
                        <input type="text" name="merchant_id" value="{{ old('merchant_id', optional($hepsiburada)->merchant_id) }}" placeholder="Hepsiburada Merchant ID" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:border-blue-500 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">API Key (Username)</label>
                        <input type="text" name="api_key" value="{{ old('api_key', optional($hepsiburada)->api_key) }}" placeholder="Hepsiburada API Key" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:border-blue-500 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">API Secret (Password)</label>
                        <input type="password" name="api_secret" value="{{ old('api_secret', optional($hepsiburada)->api_secret) }}" placeholder="••••••••••••" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:border-blue-500 transition">
                    </div>
                </div>

                <button type="submit" class="w-full py-3 bg-gray-900 hover:bg-blue-600 text-white text-xs font-bold uppercase tracking-wider rounded-xl transition shadow-sm">
                    Hepsiburada Ayarlarını Kaydet
                </button>
            </form>
        </div>

    </div>

</div>
@endsection