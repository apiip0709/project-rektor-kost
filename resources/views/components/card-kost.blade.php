<div class="bg-white rounded-xl shadow-xs border border-gray-100 overflow-hidden hover:shadow-md transition flex flex-col h-full">
    
    <div class="relative h-48 bg-gray-200">
        <a href="{{ route('kost.detail', $kost->id ?? 1) }}" class="block w-full h-full">
            <img src="{{ $kost->foto }}" alt="{{ $kost->nama }}" class="w-full h-full object-cover">
        </a>
        
        <div class="absolute top-3 left-3 flex gap-1">
            @if($kost->is_verified)
                <span class="bg-primary text-white text-[10px] font-bold px-2 py-1 rounded-sm uppercase tracking-wider flex items-center gap-0.5">
                    ✓ Verified
                </span>
            @else
                <span class="bg-secondary text-primary text-[10px] font-bold px-2 py-1 rounded-sm uppercase tracking-wider">
                    ★ Standard
                </span>
            @endif
        </div>
    </div>

    <div class="p-4 flex flex-col flex-grow">
        <span class="text-xs font-semibold uppercase tracking-wide
            {{ $kost->tipe == 'Putra' ? 'text-blue-600' : ($kost->tipe == 'Putri' ? 'text-pink-600' : 'text-purple-600') }}">
            Kost {{ $kost->tipe }}
        </span>

        <a href="{{ route('kost.detail', $kost->id ?? 1) }}" class="block">
            <h3 class="text-sm font-bold text-neutral mt-1 line-clamp-1 hover:text-primary transition cursor-pointer">
                {{ $kost->nama }}
            </h3>
        </a>

        <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
            📍 {{ $kost->jarak }}m dari {{ $kost->titik_acuan }}
        </p>

        <div class="flex flex-wrap gap-1 mt-3">
            @foreach($kost->fasilitas as $fasilitas)
                <span class="bg-gray-100 text-gray-600 text-[10px] font-bold px-2 py-0.5 rounded border border-gray-200 uppercase">
                    {{ $fasilitas }}
                </span>
            @endforeach
        </div>

        <div class="mt-auto pt-4 border-t border-gray-100">
            <div class="text-sm font-black text-primary">
                Rp {{ number_format($kost->harga_bulanan, 0, ',', '.') }}<span class="text-xs font-normal text-gray-500">/bln</span>
            </div>
            <div class="text-[10px] text-gray-400">
                Rp {{ number_format($kost->harga_tahunan, 0, ',', '.') }}/thn
            </div>
        </div>
    </div>
</div>
