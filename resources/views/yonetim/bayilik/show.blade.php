@extends('yonetim.layouts.admin')

@section('title', 'Bayilik Başvuru Detayı')
@section('page_title', 'Bayilik Başvuru Detayı')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('yonetim.bayilik.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-blue-600 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Geri Dön
        </a>

        <form action="{{ route('yonetim.bayilik.destroy', $application->id) }}" method="POST" onsubmit="return confirm('Bu başvuruyu silmek istediğinize emin misiniz?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-xs font-bold text-red-500 hover:text-red-700 transition-colors tracking-widest uppercase">
                Başvuruyu Sil
            </button>
        </form>
    </div>

    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-8 border-b border-slate-50 bg-slate-50/30">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold text-lg shadow-sm">
                        {{ substr($application->name, 0, 1) }}
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">{{ $application->full_name }}</h3>
                        <p class="text-sm text-slate-500">{{ $application->email }} • {{ $application->phone }}</p>
                    </div>
                </div>
                <div class="text-left md:text-right">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Tarih</p>
                    <p class="text-sm font-medium text-slate-700">{{ $application->created_at->translatedFormat('d F Y - H:i') }}</p>
                </div>
            </div>
        </div>

        <div class="p-8 space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Firma adı</p>
                    <p class="text-sm font-medium text-slate-900">{{ $application->company }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">İl / İlçe</p>
                    <p class="text-sm font-medium text-slate-900">{{ $application->city }} / {{ $application->district }}</p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Adres</p>
                    <p class="text-sm font-medium text-slate-900 whitespace-pre-wrap">{{ $application->address }}</p>
                </div>
                @if($application->website)
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Websitesi</p>
                    <p class="text-sm font-medium text-slate-900"><a href="{{ $application->website }}" target="_blank" rel="noopener" class="text-blue-600 hover:underline">{{ $application->website }}</a></p>
                </div>
                @endif
                @if($application->tax_department || $application->tax_no)
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Vergi</p>
                    <p class="text-sm font-medium text-slate-900">{{ $application->tax_department }} {{ $application->tax_no ? '· '.$application->tax_no : '' }}</p>
                </div>
                @endif
                @if($application->field_of_activity)
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Faaliyet alanı</p>
                    <p class="text-sm font-medium text-slate-900">{{ $application->field_of_activity }}</p>
                </div>
                @endif
                @if($application->company_references)
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Referanslar</p>
                    <p class="text-sm font-medium text-slate-900">{{ $application->company_references }}</p>
                </div>
                @endif
                @if($application->dealer_type)
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Bayilik türü</p>
                    <p class="text-sm font-medium text-slate-900">{{ $application->dealer_type_label }}</p>
                </div>
                @endif
                @if($application->message)
                <div class="md:col-span-2">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Ek not</p>
                    <p class="text-sm font-medium text-slate-900 whitespace-pre-wrap">{{ $application->message }}</p>
                </div>
                @endif
            </div>

            <div class="pt-8 border-t border-slate-50 grid grid-cols-1 md:grid-cols-2 gap-6">
                @if($application->ip_address)
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">IP ADRESİ</p>
                    <p class="text-sm font-mono font-bold text-slate-600">{{ $application->ip_address }}</p>
                </div>
                @endif
                @if($application->user_agent)
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">TARAYICI BİLGİSİ</p>
                    <p class="text-[11px] font-medium text-slate-500 italic leading-snug">{{ $application->user_agent }}</p>
                </div>
                @endif
            </div>
        </div>

        <div class="p-8 bg-slate-50/50 border-t border-slate-50 flex flex-wrap gap-4">
            <a href="mailto:{{ $application->email }}" class="inline-flex items-center px-6 py-2.5 bg-blue-600 text-white rounded-xl font-bold text-sm hover:bg-blue-700 transition-all shadow-sm">
                E-posta Gönder
            </a>
            <a href="tel:{{ $application->phone }}" class="inline-flex items-center px-6 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl font-bold text-sm hover:bg-slate-50 transition-all shadow-sm">
                Ara
            </a>
        </div>
    </div>
</div>
@endsection
