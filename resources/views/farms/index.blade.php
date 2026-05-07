<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Mening xo\'jaliklarim') }}
            </h2>
            <a href="{{ route('farms.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-150 ease-in-out">
                + Xo'jalik qo'shish
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($farms as $farm)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 hover:shadow-md transition duration-200">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $farm->name }}</h3>
                            <div class="text-sm text-gray-600 space-y-1 mb-4">
                                <p><span class="font-medium">Manzil:</span> {{ $farm->location ?? 'Belgilanmagan' }}</p>
                                <p><span class="font-medium">Maydoni:</span> {{ $farm->size ? $farm->size . ' ga' : 'Belgilanmagan' }}</p>
                                <p><span class="font-medium">Tuproq turi:</span> {{ $farm->soil_type ?? 'Belgilanmagan' }}</p>
                            </div>
                            <div class="flex justify-between items-center border-t pt-4">
                                <span class="text-xs font-semibold px-2 py-1 bg-blue-50 text-blue-700 rounded-full">
                                    {{ $farm->soil_analyses_count }} tahlillar
                                </span>
                                <div class="flex space-x-2">
                                    <a href="{{ route('farms.show', $farm->id) }}" class="text-sm text-indigo-600 hover:text-indigo-900 font-medium">Boshqarish</a>
                                    <a href="{{ route('farms.edit', $farm->id) }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium">Tahrirlash</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white p-12 text-center rounded-lg shadow-sm">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Xo'jaliklar mavjud emas</h3>
                        <p class="mt-1 text-sm text-gray-500">Birinchi xo'jaligingizni yaratish orqali boshlang.</p>
                        <div class="mt-6">
                            <a href="{{ route('farms.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                                + Xo'jalik qo'shish
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
