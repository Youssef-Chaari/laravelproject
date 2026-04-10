@props(['car', 'type' => 'new'])

@php
    $image = $car->primaryImage ?? $car->images->first();
    $imageSrc = $image ? Storage::url($image->path) : 'https://placehold.co/400x240/f8fafc/94a3b8?text=Photo';
    $url = $type === 'new' ? route('cars-new.show', $car) : route('cars-used.show', $car);
@endphp

<div class="bg-white border border-slate-200 hover:border-blue-300 rounded-2xl overflow-hidden transition-all duration-300 shadow-sm hover:shadow-md hover:-translate-y-1 block group relative">
    <a href="{{ $url }}" class="block relative overflow-hidden rounded-t-2xl" style="height: 200px;">
        <img src="{{ $imageSrc }}" alt="{{ $car->brand }} {{ $car->model }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
        @if($type === 'used')
            <span class="absolute top-3 left-3 badge-{{ $car->status }}">
                {{ ucfirst($car->status) }}
            </span>
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/30 to-transparent"></div>
    </a>
    <div class="p-5">
        <div class="flex items-start justify-between mb-3">
            <div>
                <p class="text-xs text-blue-600 font-bold uppercase tracking-wider mb-0.5">{{ $car->brand }}</p>
                <h3 class="font-bold text-slate-900 text-lg leading-tight">{{ $car->model }}
                    @if($type === 'new') <span class="text-slate-500 font-medium text-sm ml-1">{{ $car->year }}</span>@endif
                </h3>
            </div>
            <div class="text-right">
                <p class="text-orange-500 font-bold text-lg">{{ number_format($car->price, 0, ',', ' ') }} <span class="text-sm text-slate-500 font-semibold">DH</span></p>
            </div>
        </div>
        
        <div class="flex items-center gap-4 text-sm text-slate-600 font-medium mt-4">
            @if($type === 'new')
                <div class="flex items-center gap-1.5 bg-slate-50 px-2 py-1 rounded-md border border-slate-100"><svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>{{ $car->fuel_type }}</div>
                <div class="flex items-center gap-1.5 bg-slate-50 px-2 py-1 rounded-md border border-slate-100"><svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>{{ $car->transmission }}</div>
            @else
                <div class="flex items-center gap-1.5 bg-slate-50 px-2 py-1 rounded-md border border-slate-100"><svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>{{ $car->year }}</div>
                <div class="flex items-center gap-1.5 bg-slate-50 px-2 py-1 rounded-md border border-slate-100"><svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>{{ number_format($car->mileage, 0, ',', ' ') }} km</div>
            @endif
        </div>

        <a href="{{ $url }}" class="mt-5 block text-center py-2.5 px-4 rounded-xl bg-slate-100 hover:bg-blue-600 text-slate-700 hover:text-white text-sm font-semibold transition-all duration-200">
            Voir détails →
        </a>
    </div>
</div>
