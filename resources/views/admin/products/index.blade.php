@extends('layouts.admin')

@section('title', 'Algitsin - Ürün Yönetimi')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">Ürün Yönetimi</h1>
            <p class="text-sm text-slate-500">Vitrin ürünlerini yönetebilir, arayabilir ve yenilerini ekleyebilirsiniz.</p>
        </div>

        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full md:w-auto">
           
            <form action="{{ route('admin.products.index') }}" method="GET" class="relative w-full sm:w-72">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Ürün adı veya kodu ara..." 
                    class="w-full bg-white border border-slate-200 rounded-xl pl-10 pr-14 py-2 text-sm font-medium text-slate-800 focus:outline-none focus:border-brandOrange focus:ring-1 focus:ring-brandOrange transition shadow-sm placeholder:text-slate-400"
                >
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                @if(request('search'))
                    <a href="{{ route('admin.products.index') }}" class="absolute inset-y-0 right-0 pr-3 flex items-center text-xs font-bold text-rose-500 hover:underline">
                        Temizle
                    </a>
                @endif
            </form>

            <a href="{{ route('admin.products.create') }}" class="text-center bg-brandOrange text-white px-5 py-2 rounded-xl text-sm font-bold hover:bg-orange-600 transition shadow-sm whitespace-nowrap">+ Yeni Ürün Ekle</a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl mb-6 text-sm shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-sm border border-slate-200 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-600 uppercase text-xs font-semibold tracking-wider border-b border-slate-200">
                        <th class="py-4 px-4">Görseller</th>
                        <th class="py-4 px-4">Ürün Adı & Kategori</th>
                        <th class="py-4 px-4">Fiyat / Stok</th>
                        <th class="py-4 px-4">Affiliate Link</th>
                        <th class="py-4 px-4 text-center">İşlemler</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                    @forelse($products as $product)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-4 whitespace-nowrap">
                                @if($product->images && count($product->images) > 0)
                                    <div class="flex items-center gap-1.5 overflow-x-auto max-w-[140px] py-1">
                                        @foreach($product->images as $img)
                                            <img src="{{ asset($img) }}" alt="{{ $product->name }}" class="w-10 h-10 object-cover rounded-lg border border-slate-200 shadow-sm flex-shrink-0">
                                        @endforeach
                                    </div>
                                @else
                                    <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center text-slate-400 text-xs font-medium border border-slate-200">
                                        Yok
                                    </div>
                                @endif
                            </td>
                            <td class="py-4 px-4 max-w-xs">
                                <div class="font-bold text-gray-900 text-base mb-0.5">{{ $product->name }}</div>
                                <div class="text-xs text-brandBlue font-medium mb-1">{{ $product->category->name ?? 'Kategorisiz' }}</div>
                                <div class="text-slate-500 text-xs line-clamp-1">{{ $product->description ?? 'Açıklama girilmemiş.' }}</div>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <div class="font-extrabold text-brandBlue text-base">{{ number_format($product->price, 2) }} ₺</div>
                                <div class="text-xs text-slate-500 mt-0.5">Stok: <span class="font-semibold text-gray-700">{{ $product->stock }}</span></div>
                            </td>
                            <td class="py-4 px-4 max-w-xs">
                                <a href="{{ $product->affiliate_url }}" target="_blank" class="text-brandBlue hover:underline text-xs truncate block max-w-[180px]">
                                    {{ $product->affiliate_url }}
                                </a>
                            </td>
                            <td class="py-4 px-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="bg-amber-500 hover:bg-amber-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition shadow-sm">Düzenle</a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Bu ürünü silmek istediğinize emin misiniz?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition shadow-sm">Sil</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-400 font-medium">
                                @if(request('search'))
                                    Aramanıza uygun ürün bulunamadı. <a href="{{ route('admin.products.index') }}" class="text-brandOrange underline">Tüm ürünleri göster</a>
                                @else
                                    Henüz eklenmiş bir ürün bulunmuyor.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>
@endsection