<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Yangi tuproq tahlili') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('analysis.store') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="col-span-full">
                                <x-input-label for="farm_id" :value="__('Xo\'jalikni tanlang')" />
                                <select id="farm_id" name="farm_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    @foreach($farms as $farm)
                                        <option value="{{ $farm->id }}" {{ $farmId == $farm->id ? 'selected' : '' }}>{{ $farm->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('farm_id')" />
                            </div>

                            <div class="col-span-full">
                                <x-input-label for="target_crop" :value="__('Ekilgan yoki ekilmoqchi bo\'lgan ekin turi')" />
                                <x-text-input id="target_crop" name="target_crop" type="text" class="mt-1 block w-full" :value="old('target_crop')" placeholder="Masalan: Paxta, Bug'doy, Pomidor..." />
                                <x-input-error class="mt-2" :messages="$errors->get('target_crop')" />
                            </div>

                            <div>
                                <x-input-label for="analysis_date" :value="__('Tahlil sanasi')" />
                                <x-text-input id="analysis_date" name="analysis_date" type="date" class="mt-1 block w-full" :value="old('analysis_date', date('Y-m-d'))" required />
                                <x-input-error class="mt-2" :messages="$errors->get('analysis_date')" />
                            </div>

                            <div>
                                <x-input-label for="ph" :value="__('pH darajasi (3.5-9)')" />
                                <x-text-input id="ph" name="ph" type="number" step="0.1" min="3.5" max="9" class="mt-1 block w-full" :value="old('ph')" />
                                <x-input-error class="mt-2" :messages="$errors->get('ph')" />
                            </div>

                            <div>
                                <x-input-label for="fertility" :value="__('Unumdorlik (0-3000)')" />
                                <x-text-input id="fertility" name="fertility" type="number" class="mt-1 block w-full" :value="old('fertility')" />
                                <x-input-error class="mt-2" :messages="$errors->get('fertility')" />
                            </div>

                            <div>
                                <x-input-label for="moisture" :value="__('Namlik (%)')" />
                                <x-text-input id="moisture" name="moisture" type="number" step="0.1" min="0" max="99" class="mt-1 block w-full" :value="old('moisture')" />
                                <x-input-error class="mt-2" :messages="$errors->get('moisture')" />
                            </div>

                            <div>
                                <x-input-label for="temperature" :value="__('Harorat (°C)')" />
                                <x-text-input id="temperature" name="temperature" type="number" step="0.1" min="0" max="50" class="mt-1 block w-full" :value="old('temperature')" />
                                <x-input-error class="mt-2" :messages="$errors->get('temperature')" />
                            </div>

                            <div>
                                <x-input-label for="sunlight" :value="__('Quyosh nuri (LUX)')" />
                                <x-text-input id="sunlight" name="sunlight" type="number" min="0" max="100000" class="mt-1 block w-full" :value="old('sunlight')" />
                                <x-input-error class="mt-2" :messages="$errors->get('sunlight')" />
                            </div>

                            <div>
                                <x-input-label for="humidity" :value="__('Atrof-muhit namligi (%)')" />
                                <x-text-input id="humidity" name="humidity" type="number" step="0.1" min="0" max="99" class="mt-1 block w-full" :value="old('humidity')" />
                                <x-input-error class="mt-2" :messages="$errors->get('humidity')" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('dashboard') }}" class="mr-4 text-sm text-gray-600 hover:text-gray-900">{{ __('Bekor qilish') }}</a>
                            <x-primary-button>
                                {{ __('Tahlilni saqlash') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
