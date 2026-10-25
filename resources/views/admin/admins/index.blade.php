@extends('layouts.admin')

@section('title', 'Algitsin - Yönetici Paneli')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 pb-4 border-b border-slate-200 gap-4">
        <div>
            <span class="text-xs text-brandOrange font-bold uppercase tracking-widest">Yetkilendirme</span>
            <h1 class="text-2xl font-black text-gray-900 mt-1">Yönetici Listesi</h1>
        </div>
        <a href="{{ route('admin.admins.create') }}" class="bg-brandOrange hover:bg-orange-600 text-white px-5 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider transition shadow-sm">
            + Yeni Yönetici Ekle
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/30 text-emerald-600 text-sm rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-500/10 border border-red-500/30 text-red-600 text-sm rounded-xl">
            {{ session('error') }}
        </div>
    @endif

<div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[650px]">
            <thead>
                <tr class="border-b border-slate-200 text-xs text-slate-400 uppercase tracking-wider bg-slate-50">
                    <th class="p-4">Ad Soyad</th>
                    <th class="p-4">E-Posta</th>
                    <th class="p-4">Kayıt Tarihi</th>
                    <th class="p-4 text-right">İşlemler</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @foreach($admins as $admin)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="p-4 font-bold text-gray-900">{{ $admin->name }}</td>
                        <td class="p-4 text-gray-600">{{ $admin->email }}</td>
                        <td class="p-4 text-gray-500 text-xs">{{ $admin->created_at->format('d.m.Y H:i') }}</td>
                        <td class="p-4 text-right space-x-2">
                            <a href="{{ route('admin.admins.edit', $admin->id) }}" class="text-xs bg-slate-100 hover:bg-slate-200 text-gray-800 px-3 py-1.5 rounded-lg font-bold transition">Düzenle</a>
                            @if(Auth::guard('admin')->id() !== $admin->id)
                                <form action="{{ route('admin.admins.destroy', $admin->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Bu yöneticiyi silmek istediğinize emin misiniz?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs bg-red-50 hover:bg-red-600 text-red-600 hover:text-white px-3 py-1.5 rounded-lg font-bold transition">Sil</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
@endsection