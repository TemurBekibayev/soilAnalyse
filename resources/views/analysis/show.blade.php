<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tuproq tahlili hisoboti') }} - {{ $analysis->farm->name }}
            </h2>
            <div class="text-sm text-gray-500">
                Tahlil sanasi: {{ $analysis->analysis_date }}
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 shadow-sm" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Data Overview -->
                <div class="md:col-span-1 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4 border-b pb-2">Tahlil ma'lumotlari</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600 font-medium">pH darajasi</span>
                            <span class="font-bold {{ $analysis->ph < 5.5 || $analysis->ph > 7.5 ? 'text-red-600' : 'text-green-600' }}">
                                {{ $analysis->ph ?? 'N/A' }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 font-medium">Unumdorlik</span>
                            <span class="font-bold">{{ $analysis->fertility ?? 'N/A' }} / 3000</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 font-medium">Namlik</span>
                            <span class="font-bold">{{ $analysis->moisture ?? 'N/A' }}%</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 font-medium">Harorat</span>
                            <span class="font-bold">{{ $analysis->temperature ?? 'N/A' }}°C</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 font-medium">Quyosh nuri</span>
                            <span class="font-bold">{{ $analysis->sunlight ?? 'N/A' }} LUX</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 font-medium">Havo namligi</span>
                            <span class="font-bold">{{ $analysis->humidity ?? 'N/A' }}%</span>
                        </div>
                    </div>

                    <div class="mt-8">
                        @if($analysis->status === 'pending')
                            <form action="{{ route('analysis.recommend', $analysis->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded shadow-lg transition flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                    AI Tavsiyalarini olish
                                </button>
                            </form>
                        @else
                            <div class="bg-green-50 text-green-700 p-3 rounded-lg text-center text-sm font-medium">
                                Hisobot yakunlangan
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Recommendation Content -->
                <div class="md:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4 border-b pb-2">AI Tavsiyalari va Ma'lumotlar</h3>
                    
                    @if($analysis->recommendation)
                        <div class="prose max-w-none text-gray-700">
                            {!! Illuminate\Support\Str::markdown($analysis->recommendation->content) !!}
                        </div>

                        @if($analysis->recommendation->recommended_crops)
                            <div class="mt-8 border-t pt-6">
                                <h4 class="font-bold mb-3">Tavsiya etiladigan ekinlar</h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($analysis->recommendation->recommended_crops as $crop)
                                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                                            {{ $crop }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($analysis->recommendation->fertilizer_plan)
                            <div class="mt-8 border-t pt-6">
                                <h4 class="font-bold mb-3">O'g'itlash rejasi</h4>
                                <ul class="list-disc pl-5 space-y-2">
                                    @foreach($analysis->recommendation->fertilizer_plan as $item)
                                        <li class="text-gray-700">
                                            <span class="font-semibold">{{ $item['type'] ?? 'O\'g\'it' }}</span>: {{ $item['amount'] ?? 'Zarur miqdorda' }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                            <p class="mt-4 text-gray-500 italic">Tuproq ma'lumotlari asosida shaxsiy qishloq xo'jaligi maslahatlarini olish uchun "AI Tavsiyalarini olish" tugmasini bosing.</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex justify-between items-center">
                <a href="{{ route('farms.show', $analysis->farm_id) }}" class="text-gray-600 hover:text-gray-900 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Xo'jalikka qaytish
                </a>
                
                <form action="{{ route('analysis.destroy', $analysis->id) }}" method="POST" onsubmit="return confirm('Ushbu tahlil yozuvini o\'chirib tashlaysizmi?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-900 text-sm">Yozuvni o'chirish</button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
