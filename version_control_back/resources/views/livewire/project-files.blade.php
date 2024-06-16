<div class="space-y-4">
    <div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <h1 class="text-3xl font-bold mb-6 text-gray-900 dark:text-white">{{ $project->name }}</h1>

        <form wire:submit.prevent="uploadFile" class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Upload file</label>
            <input type="file" wire:model="file" id="file_input" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
            @error('file') <span class="text-red-500 text-sm mt-2">{{ $message }}</span> @enderror
            <button type="submit" class="mt-4 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-500 dark:hover:bg-blue-600">Upload</button>
        </form>

        <h2 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">Файлы проекта</h2>
        <ul class="space-y-2 mb-6">
            @foreach($files as $file)
                <li wire:click="showFileVersions('{{ $file->file_name }}')" class="cursor-pointer text-blue-600 hover:underline dark:text-blue-400">{{ $file->file_name }}</li>
            @endforeach
        </ul>

        @if($fileName)
            <h3 class="text-xl font-medium mb-4 text-gray-900 dark:text-white">Версии файла: {{ $fileName }}</h3>
            <ul class="space-y-2">
                @foreach($versions as $version)
                    <li class="text-gray-700 dark:text-gray-300">
                        {{ $version->file_name }} - v{{ $version->version }} -
                        <a href="{{ Storage::url($version->file_path) }}" target="_blank" class="text-blue-600 hover:underline dark:text-blue-400">Download</a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
    <h1 class="text-3xl font-bold mb-6 text-gray-900 dark:text-white">Обозреватель решения BIM/IFC/IFE</h1>
    <embed src="http://localhost:5173" width="100%" height="900px" type="" class="rounded-xl">
</div>
