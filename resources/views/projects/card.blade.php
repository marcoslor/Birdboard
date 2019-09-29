<h3 class="h3 text-xl py-4 -ml-5 border-l-4 border-accent-light pl-4 font-semibold mb-2">
    <a href="{{ $project->path() }}">{{ $project->title }}</a>
</h3>
<div class="flex-1">
    <p class="text-gray-500 truncate h-100">{{ Str::limit($project->description, 100) }}</p>
</div>
@can('manage', $project)
<footer class="text-right flex-fill">
    <form action="{{ $project->path() }}" method="POST">
        @method('DELETE')
        @csrf
        <button type="submit">Delete</button>
    </form>
</footer>
@endcan
