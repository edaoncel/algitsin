<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yönetici Girişi - Algitsin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-950 text-white flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md p-8 bg-gray-900 border border-gray-800 rounded-3xl shadow-2xl">
        <div class="text-center mb-8">
            <span class="text-xs uppercase tracking-widest text-orange-500 font-extrabold">Algitsin Panel</span>
            <h1 class="text-2xl font-black mt-1">Yönetici Girişi</h1>
        </div>

        @if($errors->any())
            <div class="mb-4 p-3 bg-red-500/10 border border-red-500/30 text-red-400 text-xs rounded-xl">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase mb-1">E-Posta Adresi</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full bg-gray-950 border border-gray-800 rounded-xl p-3 text-sm focus:border-orange-500 outline-none transition">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Şifre</label>
                <input type="password" name="password" required class="w-full bg-gray-950 border border-gray-800 rounded-xl p-3 text-sm focus:border-orange-500 outline-none transition">
            </div>

            <button type="submit" class="w-full bg-orange-600 hover:bg-orange-500 text-white font-bold py-3 rounded-xl transition text-sm uppercase tracking-wider shadow-lg shadow-orange-600/20">
                Giriş Yap
            </button>
        </form>
    </div>
</body>
</html>