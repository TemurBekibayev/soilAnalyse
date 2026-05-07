<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Farm') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('farms.store') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="name" :value="__('Farm Name')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <div>
                                <x-input-label for="location" :value="__('Location (City, Region)')" />
                                <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" :value="old('location')" />
                                <x-input-error class="mt-2" :messages="$errors->get('location')" />
                            </div>

                            <div>
                                <x-input-label for="size" :value="__('Size (Hectares)')" />
                                <x-text-input id="size" name="size" type="number" step="0.01" class="mt-1 block w-full" :value="old('size')" />
                                <x-input-error class="mt-2" :messages="$errors->get('size')" />
                            </div>

                            <div>
                                <x-input-label for="soil_type" :value="__('General Soil Type')" />
                                <select id="soil_type" name="soil_type" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Select soil type</option>
                                    <option value="Silty" {{ old('soil_type') == 'Silty' ? 'selected' : '' }}>Silty</option>
                                    <option value="Loamy" {{ old('soil_type') == 'Loamy' ? 'selected' : '' }}>Loamy</option>
                                    <option value="Clay" {{ old('soil_type') == 'Clay' ? 'selected' : '' }}>Clay</option>
                                    <option value="Sandy" {{ old('soil_type') == 'Sandy' ? 'selected' : '' }}>Sandy</option>
                                    <option value="Peaty" {{ old('soil_type') == 'Peaty' ? 'selected' : '' }}>Peaty</option>
                                    <option value="Chalky" {{ old('soil_type') == 'Chalky' ? 'selected' : '' }}>Chalky</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('soil_type')" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('farms.index') }}" class="mr-4 text-sm text-gray-600 hover:text-gray-900">Cancel</a>
                            <x-primary-button>
                                {{ __('Create Farm') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
