@extends('layouts.store')

@section('title', 'Alveral - E- Ticaret Resmi Satış Sitesi')

@section('content')

<header class="bg-gray-200 text-white py-16 px-6 text-center relative overflow-hidden">
    <div class="max-w-4xl mx-auto relative z-10">
        <span class="text-brandOrange tracking-widest text-xs uppercase font-extrabold mb-3 block">Burdur Çavdır'dan Dünyaya</span>
        <h1 class="text-4xl sm:text-5xl font-black mb-4 tracking-tight uppercase">Hikayemiz</h1>
        <p class="text-gray-400 text-sm sm:text-base max-w-xl mx-auto font-light leading-relaxed">30 yılı aşkın aile birikimimiz ve dijital vizyonumuzla buradayız.</p>
    </div>
</header>


<div class="max-w-6xl mx-auto px-4 sm:px-8 py-16 w-full">
    
    
    <div class="bg-gray-50 border border-gray-100 rounded-3xl p-8 sm:p-12 shadow-sm mb-16 leading-relaxed text-gray-600 space-y-5">
        <p class="text-lg sm:text-xl font-black text-gray-900">
            Burdur’un samimi ve sıcak kalbi Çavdır’da, 30 yılı aşkın süredir ticaretin içinden gelen köklü bir aile şirketiyiz.
        </p>
        <p class="text-sm sm:text-base font-light">
            Yıllardır dükkanımızda terzilikten perde tasarımlarına kadar binbir emekle büyüttüğümüz esnaflık kültürünü ve güveni şimdi dijital dünyaya taşıyoruz. Bir anne ve iki kızı olarak; kadın elinin değdiği her işte olduğu gibi ticarette de zarafeti, dürüstlüğü ve samimiyeti en başköşeye koyuyoruz.
        </p>
        <p class="text-sm sm:text-base font-light">
            <strong class="text-gray-900 font-bold">Alveral</strong> çatısı altında; mottolarımızla en seçkin ürünleri en hızlı şekilde kapınıza getiriyoruz. Ailemizin 30 yıllık ticaret tecrübesini ve sıcaklığını sizlerle buluşturmaktan gurur duyuyoruz.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
        
        
        <div class="lg:col-span-5 space-y-8">
            <div class="bg-white border border-gray-100 p-8 rounded-3xl shadow-sm">
                <h3 class="font-black text-xl text-gray-900 mb-2">Instagram Hesaplarımız</h3>
                <p class="text-xs text-gray-400 mb-6 font-light">Özel koleksiyonlarımız ve avantajlı dünyamız için bizi takip edin:</p>
                
                <div class="space-y-3">
                    <a href="https://www.instagram.com/alveral.tr/" target="_blank" class="flex items-center gap-3 p-4 bg-gray-50 hover:bg-orange-50 hover:text-brandOrange rounded-2xl font-bold text-xs transition border border-gray-100">
                         Alveral
                    </a>
                </div>
            </div>
        </div>

        
        <div class="lg:col-span-7 bg-white border border-gray-100 p-8 sm:p-10 rounded-3xl shadow-sm">
            <h3 class="font-black text-2xl text-gray-900 mb-1">Bize Mesaj Gönderin</h3>
            <p class="text-xs text-gray-400 mb-8 font-light">Görüş, öneri ve talepleriniz için doğrudan bize yazabilirsiniz.</p>

            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 text-xs font-bold rounded-2xl">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('contact.store') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Adınız Soyadınız</label>
                    <input type="text" name="name" required class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-5 py-3.5 text-sm focus:outline-none focus:border-brandOrange transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">E-Posta Adresiniz</label>
                    <input type="email" name="email" required class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-5 py-3.5 text-sm focus:outline-none focus:border-brandOrange transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Konu</label>
                    <input type="text" name="subject" class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-5 py-3.5 text-sm focus:outline-none focus:border-brandOrange transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Mesajınız</label>
                    <textarea name="message" rows="4" required class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-5 py-3.5 text-sm focus:outline-none focus:border-brandOrange transition"></textarea>
                </div>
                <button type="submit" class="w-full bg-gray-900 hover:bg-brandOrange text-white font-bold py-4 rounded-2xl text-xs uppercase tracking-wider transition shadow-sm">
                    Mesaj Gönder
                </button>
            </form>
        </div>

    </div>
</div>
@endsection