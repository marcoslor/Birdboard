@extends('layouts.app')
@section('content')
    <div class="flex w-full">
        <div class="card m-auto p-12">
            <form method="POST" action="{{$project->path()}}">
                @csrf
                @method('patch')

                <h1 class="text-2xl text-center mb-4">Edit a project</h1>

                <label for="title">Title</label>
                <input class="border rounded block w-full mb-4 mt-2" type="text" name="title" placeholder="Title" value="{{$project->title}}">

                <label for="description">Description</label>
                <textarea class="border rounded block w-full mb-4 mt-2" name="description" id="" cols="100" rows="8">{{$project->description}}</textarea>

                <div class="flex w-full justify-between mt-8">
                    <button class="button" type="submit">Submit</button>
                    <a href="{{$project->path()}}">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endSection

