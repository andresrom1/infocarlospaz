<x-app-layout>
    <x-slot name="header">
        <div class="flex items-end gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>
        <div class="grid grid-cols-2 py-4 px-4 gap-4">
            <x-form-create/>
        </div>

</x-app-layout>
