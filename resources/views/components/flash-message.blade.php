@if(session('success'))
    <div class="flex items-center gap-3 px-4 py-3 rounded-xl border bg-green-50 border-green-200 text-green-800 font-medium shadow-sm animate-fade-in mb-6" role="alert">
        <span class="w-6 h-6 flex items-center justify-center rounded-full bg-green-100 text-green-600 font-bold text-sm">✓</span>
        <span>{{ session('success') }}</span>
    </div>
@endif

@if(session('error'))
    <div class="flex items-center gap-3 px-4 py-3 rounded-xl border bg-red-50 border-red-200 text-red-800 font-medium shadow-sm animate-fade-in mb-6" role="alert">
        <span class="w-6 h-6 flex items-center justify-center rounded-full bg-red-100 text-red-600 font-bold text-sm">✗</span>
        <span>{{ session('error') }}</span>
    </div>
@endif
