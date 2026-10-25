<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yeni Yönetici Ekle - Algitsin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-950 text-white min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-lg p-8 bg-gray-900 border border-gray-800 rounded-3xl shadow-2xl">
        <div class="mb-6">
            <a href="{{ route('admin.admins.index') }}" class="text-xs text-orange-500 hover:underline font-bold uppercase tracking-widest">← Listeye Dön</a>
            <h1 class="text-2xl font-black mt-1">Yeni Yönetici Ekle</h1>
        </div>

        @if($errors->any())
            <div class="mb-4 p-3 bg-red-500/10 border border-red-500/30 text-red-400 text-xs rounded-xl">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.admins.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Ad Soyad</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full bg-gray-950 border border-gray-800 rounded-xl p-3 text-sm focus:border-orange-500 outline-none transition">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase mb-1">E-Posta Adresi</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full bg-gray-950 border border-gray-800 rounded-xl p-3 text-sm focus:border-orange-500 outline-none transition">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Şifre</label>
                <input type="password" name="password" required class="w-full bg-gray-950 border border-gray-800 rounded-xl p-3 text-sm focus:border-orange-500 outline-none transition">
            </div>

            <button type="submit" class="w-full bg-orange-600 hover:bg-orange-500 text-white font-bold py-3 rounded-xl transition text-sm uppercase tracking-wider shadow-lg shadow-orange-600/20">
                Kaydet
            </button>
        </form>
    </div>
</body>
</html>