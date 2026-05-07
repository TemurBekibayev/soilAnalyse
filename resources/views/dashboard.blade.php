<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Boshqaruv paneli') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm font-medium">Jami xo'jaliklar</div>
                    <div class="text-3xl font-bold text-green-600">{{ $farmsCount }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm font-medium">Jami tuproq tahlillari</div>
                    <div class="text-3xl font-bold text-blue-600">{{ $analysesCount }}</div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Oxirgi tuproq tahlillari</h3>
                    @if($recentAnalyses->isEmpty())
                        <p class="text-gray-500">Tahlillar topilmadi. <a href="{{ route('farms.index') }}" class="text-green-600 hover:underline">Xo'jalik qo'shish</a> orqali boshlang.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Xo'jalik</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sana</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Holati</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harakat</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($recentAnalyses as $analysis)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $analysis->farm->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $analysis->analysis_date }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $analysis->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ $analysis->status === 'completed' ? 'Yakunlangan' : 'Kutilmoqda' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('analysis.show', $analysis->id) }}" class="text-indigo-600 hover:text-indigo-900">Ko'rish</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('farms.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow-lg transition duration-150 ease-in-out">
                    + Yangi xo'jalik qo'shish
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
