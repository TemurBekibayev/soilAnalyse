<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $farm->name }} - {{ __('Tafsilotlar') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('analysis.create', ['farm_id' => $farm->id]) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                    + Yangi tahlil
                </a>
                <a href="{{ route('farms.edit', $farm->id) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded transition">
                    Tahrirlash
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Tuproq tahlili tarixi</h3>
                @if($farm->soilAnalyses->isEmpty())
                    <div class="text-center py-8">
                        <p class="text-gray-500 mb-4">Ushbu xo'jalik uchun tahlil tarixi mavjud emas.</p>
                        <a href="{{ route('analysis.create', ['farm_id' => $farm->id]) }}" class="text-blue-600 hover:underline">Birinchi tuproq tahlilini o'tkazing</a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sana</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">pH</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unumdorlik / Namlik</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Holati</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harakat</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($farm->soilAnalyses as $analysis)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $analysis->analysis_date }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $analysis->ph ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $analysis->fertility ?? '?' }} / {{ $analysis->moisture ?? '?' }}%
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $analysis->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ $analysis->status === 'completed' ? 'Yakunlangan' : 'Kutilmoqda' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('analysis.show', $analysis->id) }}" class="text-indigo-600 hover:text-indigo-900">Hisobotni ko'rish</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <div class="flex justify-end">
                <form action="{{ route('farms.destroy', $farm->id) }}" method="POST" onsubmit="return confirm('Haqiqatan ham ushbu xo\'jalikni va uning barcha tarixini o\'chirib tashlamoqchimisiz?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">
                        Xo'jalikni o'chirish
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
