<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;

class ProjectsController extends Controller
{
    public function index(){
        $projects = auth()->user()->projects;
        return view('projects.index')->with('projects',$projects);
    }

    public function show(Project $project){
        $this->authorize('update', $project);

        return view('projects.show')->with('project',$project);
    }
    public function store(){
        //validate
        $attributes = request()->validate
        (
            ['title'=>'required',
            'description'=>'required']
        );

        //persist
        $project = auth()->user()->projects()->create($attributes);

        //redirect
        return redirect($project->path());
    }

    public function create(){
        return view('projects.create');
    }

    public function update(Project $project){
        $this->authorize('update', $project);

        $attributes = \request()->validate([
            'title'=>'required',
            'description'=>'required',
            'notes'=>'required'
        ]);
        $project->update($attributes);
        return redirect($project->path());
    }


}
