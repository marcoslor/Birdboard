@extends('layouts.app')
@section('content')
    <div id="task-app">
        <header class="flex items-end justify-between mb-4 py-4">
            <p class="h2 text-gray-600 truncate"><a href="/projects">My Projects</a> / {{$project->title}}</p>
            <a class="button ml-2" href="/projects/create">New Project</a>
        </header>
        <main class="lg:flex flex-wrap -mx-3">
            <div class="lg:w-1/4 px-3 mt-10">
                <div class="card">
                    @if (strlen($project->description)>100)
                        <h3 class="h3 text-xl py-4 -ml-5 border-l-4 border-blue-light pl-4 font-semibold mb-2">
                            <a href="{{$project->path()}}">{{$project->title}}</a>
                        </h3>
                        <input type="checkbox" class="read-more-state hidden" id="project-more" />
                        <p class="text-gray-500 read-more-wrap">
                            @php
                                $str = $project->description;
                                $pos = 100;
                                $trim = substr($str, 0, $pos);
                                $more = substr($str, $pos);
                                echo $trim
                            @endphp
                            <span class="read-more-target">
                            @php
                                echo $more
                            @endphp
                        </span>
                        </p>
                        <label for="project-more" class="read-more-trigger"></label>
                    @else
                        @include('projects.card')
                    @endif
                </div>
                <h2 class="h2 text-lg mt-3 text-gray-600">Activities</h2>
                @include('projects.activity.card')
            </div>
            <div class="lg:w-3/4 px-3 mb-6 lg:order-first">
                <div class="mb-8">
                    <h2 class="h2 text-lg mb-3 text-gray-600">Tasks</h2>
                    @forelse($project->tasks as $task)
                        <div class=" mb-3 card">
                            <form action="{{$task->path()}}" method="POST">
                                @method("PATCH")
                                @csrf
                                <div class="flex items-center">
                                    <input class="w-full {{$task->completed?'text-gray-400 line-through':''}}" value="{{$task->body}}" name="body">
                                    <input type="checkbox" name="completed" onchange="this.form.submit()" {{$task->completed?'checked':''}}>
                                </div>
                            </form>
                        </div>
                    @empty
                    @endforelse
                    <div class="card mb-3">
                        <form action="{{$project->path().'/tasks'}}" method="POST">
                            @csrf
                            <input name="body" type="text" class="w-full" placeholder="Begin by adding tasks...">
                        </form>
                    </div>
                </div>
                <div class="">
                    <h2 class="h2 text-lg mb-3 text-gray-600">General Notes</h2>
                    <form action="{{$project->path()}}" method="POST">
                        @method("PATCH")
                        @csrf
                        <textarea class="card w-full" name='notes' style="min-height: 16rem;" placeholder="Your notes go here">{{ $project->notes }}</textarea>
                        <button class="button mt-4">Save</button>
                    </form>

                </div>
            </div>
        </main>
    </div>
@endSection
