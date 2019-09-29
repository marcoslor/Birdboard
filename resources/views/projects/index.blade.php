@extends('layouts.app')

@section('content')
    <header class="flex items-end justify-between mb-4 py-4 text-default">
        <h2 class="h2">My Projects</h2>

        <button class="button" @click.prevent="$modal.show('create-project')">New Project</button>
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

    <modal name="create-project" classes="card p-16" height="auto">
        <h1 class="font-normal text-2xl mb-12 text-center">Lets Start Something New</h1>
        <div class="flex mb-4">
            <div class="flex-1 mr-4">
                <div class="mb-4">
                    <label for="title" class="text-sm ml-1">Title</label>
                    <input type="text" id="title"
                           class="mt-1 w-full text-input border border-muted-light rounded p-2 text-xs"
                           autocomplete="off" placeholder="My awesome next project.">
                </div>
                <div>
                    <label for="description" class="text-sm ml-1">Description</label>
                    <textarea id="description"
                              class="mt-1 w-full text-input border border-muted-light rounded p-2 text-xs" rows="7"
                              autocomplete="off" style="max-height:20vh"
                              placeholder="I should start playing the piano."></textarea>
                </div>
            </div>
            <div class="flex-1 ml-4">
                <div>
                    <label class="text-sm ml-1">Lets add some tasks</label>
                    <input type="text"
                           class="mt-1 w-full text-input border border-muted-light rounded p-2 text-xs mb-4">
                    <button class="text-xs flex items-center">
                        <span class="material-icons mr-4">
                            add_circle_outline
                        </span>
                        <span>Add new task field</span>
                    </button>
                </div>
            </div>
        </div>
        <footer class="flex justify-end">
            <button class="button is-outlined mr-4">Cancel</button>
            <button class="button">Add project</button>
        </footer>
    </modal>
@endSection
