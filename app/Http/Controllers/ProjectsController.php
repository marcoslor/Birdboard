<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;

class ProjectsController extends Controller
{
    protected function validateRequest()
    {
        return request()->validate([
            'title' => 'sometimes|required',
            'description' => 'sometimes|nullable',
            'notes' => 'sometimes|nullable'
        ]);
    }

    public function index()
    {
        $projects = auth()->user()->avaliableProjects();
        return view('projects.index')->with('projects',$projects);
    }

    public function show(Project $project)
    {
        $this->authorize('update', $project);

        return view('projects.show')->with('project',$project);
    }

    public function store()
    {
        //validate
        $attributes = $this->validateRequest();

        //persist
        $project = auth()->user()->projects()->create($attributes);

        //redirect
        return redirect($project->path());
    }

    public function create()
    {
        return view('projects.create');
    }

    public function update(Project $project)
    {
        $this->authorize('update', $project);

        $attributes = $this->validateRequest();
        $project->update($attributes);
        return redirect($project->path());
    }

    public function edit(Project $project)
    {
        return view('projects.edit')->with('project',$project);
    }

    public function destroy(Project $project)
    {
        $this->authorize('update', $project);

        $project->delete();
        return redirect('/projects');
    }
}
