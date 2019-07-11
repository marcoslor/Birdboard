@extends('layouts.app')

@section('content')
    <header class="flex items-end justify-between mb-4 py-4">
        <h2 class="h2">My Projects</h2>

        <a class="button " href="/projects/create">New Project</a>
    </header>

    <main class="flex flex-wrap -mx-4">
        @forelse($projects as $project)
            <div class="w-1/3 p-4">
                <div class="card h-64">
                    @include('projects.card')
                </div>
            </div>
        @empty
            <li>No projects yet.</li>
        @endforelse
    </main>
@endSection