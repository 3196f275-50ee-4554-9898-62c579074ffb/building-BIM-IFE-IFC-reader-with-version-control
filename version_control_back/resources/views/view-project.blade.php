<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Проект 2
        </h2>
    </x-slot>

    <div class="py-12 select-none px-4">
        <h1 class="text-center text-3xl font-bold text-gray-700 mb-4">Ваши проекты</h1>
        <livewire:project-files :project="$project" />
    </div>
</x-app-layout>
