<div class="space-y-4">
    <ul>
        @foreach($projects as $project)
            <li>{{ $project->name }}</li>

            <a href="{{ route('project.view', $project->id) }}" class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                <img class="object-cover w-full rounded-t-lg h-96 md:h-auto md:w-48 md:rounded-none md:rounded-s-lg" src="{{ env('BUILDING_AGW', 'http://192.168.10.16:8000') }}/video/imagesmock?image={{ $project->id }}.png" alt="">
                <div class="flex flex-col justify-between p-4 leading-normal">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $project->name }}</h5>
                </div>
            </a>

        @endforeach
    </ul>
</div>
