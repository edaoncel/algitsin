@extends('layouts.admin')

@section('title', 'Alveral - Pazaryeri Entegrasyon Logları')

@section('content')
<div class="max-w-6xl mx-auto space-y-8">
    
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 pb-6 border-b border-slate-200">
        <div>
            <span class="text-[10px] text-brandOrange font-black uppercase tracking-widest">Sistem Takibi</span>
            <h1 class="text-3xl font-black text-gray-900 mt-1 tracking-tight">Entegrasyon Logları</h1>
            <p class="text-gray-500 text-xs sm:text-sm font-light mt-1">Trendyol ve Hepsiburada API işlem geçmişini ve hata raporlarını inceleyin.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.marketplaces.settings') }}" class="px-5 py-2.5 bg-white border border-slate-200 hover:border-slate-300 text-gray-700 rounded-xl font-bold text-xs transition shadow-sm">
                ← API Ayarları
            </a>
            <form action="{{ route('admin.marketplaces.syncAll') }}" method="POST">
                @csrf
                <button type="submit" class="px-5 py-2.5 bg-brandOrange hover:bg-orange-600 text-white rounded-xl font-bold text-xs transition shadow-sm uppercase tracking-wider">
                    Tümünü Senkronize Et
                </button>
            </form>
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

    <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
        <form method="GET" action="{{ route('admin.marketplaces.logs') }}" class="flex flex-col sm:flex-row gap-4 items-center justify-between">
            <div class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
                <select name="marketplace" class="px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:border-brandOrange">
                    <option value="">Tüm Pazaryerleri</option>
                    <option value="trendyol" {{ request('marketplace') == 'trendyol' ? 'selected' : '' }}>Trendyol</option>
                    <option value="hepsiburada" {{ request('marketplace') == 'hepsiburada' ? 'selected' : '' }}>Hepsiburada</option>
                </select>

                <select name="status" class="px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:border-brandOrange">
                    <option value="">Tüm Durumlar</option>
                    <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Başarılı (Success)</option>
                    <option value="error" {{ request('status') == 'error' ? 'selected' : '' }}>Hatalı (Error)</option>
                </select>

                <button type="submit" class="px-5 py-2.5 bg-gray-900 hover:bg-brandOrange text-white text-xs font-bold rounded-xl transition uppercase tracking-wider">
                    Filtrele
                </button>
            </div>

            @if(request()->filled('marketplace') || request()->filled('status'))
                <a href="{{ route('admin.marketplaces.logs') }}" class="text-xs font-bold text-slate-400 hover:text-gray-700 transition">
                    Filtreleri Temizle
                </a>
            @endif
        </form>
    </div>

    <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-[10px] uppercase font-black tracking-widest text-slate-400">
                        <th class="py-4 px-6">ID</th>
                        <th class="py-4 px-6">Pazaryeri</th>
                        <th class="py-4 px-6">İşlem (Action)</th>
                        <th class="py-4 px-6">Durum</th>
                        <th class="py-4 px-6">Mesaj / Detay</th>
                        <th class="py-4 px-6">Zaman</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($logs as $log)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6 font-bold text-slate-400">#{{ $log->id }}</td>
                            <td class="py-4 px-6 font-bold uppercase tracking-wider text-gray-800">
                                <span class="px-2.5 py-1 rounded-lg text-[10px] {{ $log->marketplace == 'trendyol' ? 'bg-orange-50 text-brandOrange' : 'bg-blue-50 text-blue-600' }}">
                                    {{ $log->marketplace }}
                                </span>
                            </td>
                            <td class="py-4 px-6 font-semibold text-gray-700">{{ $log->action }}</td>
                            <td class="py-4 px-6">
                                @if($log->status === 'success')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600">Başarılı</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-50 text-rose-600">Hata</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-gray-600 max-w-xs truncate" title="{{ $log->message }}">
                                {{ $log->message ?? '-' }}
                            </td>
                            <td class="py-4 px-6 text-slate-400 font-light text-[11px]">
                                {{ $log->created_at?->format('d.m.Y H:i:s') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-12 text-slate-400 text-sm">
                                Henüz kaydedilmiş bir entegrasyon logu bulunmuyor.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
            <div class="p-6 border-t border-slate-100">
                {{ $logs->withQueryString()->links() }}
            </div>
        @endif
    </div>

</div>
@endsection