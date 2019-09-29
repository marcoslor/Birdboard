@extends('layouts.app')
@section('content')
    <div id="task-app">
        <header class="flex justify-between mb-4 py-4">
            <p class="h2 text-default"><a href="/projects">My Projects</a> / {{ $project->title }}</p>
            <div class="inline-flex">
                <div class="overflow-hidden @if(auth()->user()->is($project->owner)) invited @endif">
                    <ul class="inline-flex">
                        @foreach($project->members as $member)
                            <li class="mx-1">
                                <img src="{{ $member->gravatarUrl() }}" class="rounded-full w-10 h-10"
                                     style="max-width: unset" alt="">
                            </li>
                        @endforeach
                        <li class="mx-1">
                            <img src="{{ $project->owner->gravatarUrl() }}" class="rounded-full w-10 h-10"
                                 style="max-width: unset" alt="">
                        </li>
                        @if(auth()->user()->is($project->owner))
                            <li class="flex">
                                <invited>
                                </invited>
                            </li>
                        @endif
                    </ul>
                </div>
                <button>
                    <i class="mi mi-add-circle-outline"></i>
                </button>
                <a class="button ml-2 whitespace-no-wrap " style="height: fit-content"
                   href="{{ $project->path() }}/edit">Edit Project</a>
            </div>
        </header>
        <main class="lg:flex flex-wrap -mx-3">
            <div class="lg:w-1/4 px-3 mt-10">
                <div class="card">
                    @if (strlen($project->description)>100)
                        <h3 class="h3 text-xl py-4 -ml-5 border-l-4 border-accent-light pl-4 font-semibold mb-2">
                            <a href="{{ $project->path() }}">{{ $project->title }}</a>
                        </h3>
                        <input type="checkbox" class="read-more-state hidden" id="project-more" />
                        <p class="text-primary read-more-wrap mb-2">
                            @php
                                $str = $project->description;
                                $pos = 100;
                                $trim = substr($str, 0, $pos);
                                $more = substr($str, $pos);
                                echo $trim
                            @endphp
                            <span class="read-more-target">{{ $more }}</span>
                        </p>
                        <label for="project-more" class="read-more-trigger text-muted"></label>
                        <footer class="text-right flex-fill">
                            <form action="{{ $project->path() }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button type="submit">Delete</button>
                            </form>
                        </footer>
                    @else
                        @include('projects.card')
                    @endif
                </div>
                <h2 class="h2 text-lg mt-3 text-default">Activities</h2>
                @include('projects.activity.card')
            </div>
            <div class="lg:w-3/4 px-3 mb-6 lg:order-first">
                <div class="mb-8">
                    <h2 class="h2 text-lg mb-3 text-default">Tasks</h2>
                    @forelse($project->tasks as $task)
                        <div class="mb-3 card">
                            <form action="{{ $task->path() }}" method="POST">
                                @method("PATCH")
                                @csrf
                                <div class="flex items-center">
                                    <input class="w-full text-input {{$task->completed?'text-muted line-through':''}}"
                                           value="{{$task->body}}" name="body">
                                    <input type="checkbox" name="completed" onchange="this.form.submit()" {{$task->completed?'checked':''}}>
                                </div>
                            </form>
                        </div>
                    @empty
                    @endforelse
                    <div class="card mb-3">
                        <form action="{{ $project->path().'/tasks' }}" method="POST">
                            @csrf
                            <input name="body" type="text" class="w-full text-input"
                                   placeholder="Begin by adding tasks...">
                        </form>
                    </div>
                </div>
                <div class="">
                    <h2 class="h2 text-lg mb-3 text-default">General Notes</h2>
                    <form action="{{ $project->path() }}" method="POST">
                        @method("PATCH")
                        @csrf
                        <textarea class="card w-full text-default text-input bg-card" name='notes'
                                  style="min-height: 16rem;"
                                  placeholder="Your notes go here">{{ $project->notes }}</textarea>
                        <button class="button mt-4">Save</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
@endSection
