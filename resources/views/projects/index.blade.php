@extends('layouts.app')

@section('content')
    <header class="flex items-end justify-between mb-4 py-4 text-default">
        <h2 class="h2">My Projects</h2>

        <a class="button " href="/projects/create">New Project</a>
    </header>

    <main class="">
        @forelse($projects as $project)
            @if($loop->first)
                <ul class="flex flex-wrap -mx-4">
            @endif
            <li class="w-1/3 p-4">
                <div class="card h-64 flex flex-col">
                    @include('projects.card')
                </div>
            </li>
            @if($loop->last)
                </ul>
            @endif
        @empty
            <span class="text-default">No projects yet.</span>
        @endforelse
    </main>
@endSection
