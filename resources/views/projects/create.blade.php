@extends('layouts.app')
@section('content')
    <h1>Create a project</h1>

    <form method="POST" action="/projects">
        @csrf

        <div class="">
            <label for="title">Title</label>
            <input type="text" name="title" placeholder="Title">
        </div>

        <div class="">
            <label for="description">Description</label>
            <textarea name="description" id="" cols="30" rows="10"></textarea>
        </div>

        <button type="submit">Submit</button>
        <a href="/projects">Cancel</a>
    </form>
@endSection

