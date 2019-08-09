<h3 class="h3 text-xl py-4 -ml-5 border-l-4 border-blue-light pl-4 font-semibold mb-2">
    <a href="{{$project->path()}}">{{$project->title}}</a>
</h3>
<p class="text-gray-500">{{Str::limit($project->description, 100)}}</p>

<footer class="text-right">
    <form action="{{$project->path()}}" method="post">
        @method('DELETE')
        <button type="submit">Delete</button>
    </form>
</footer>
