<?php

namespace App\Http\Controllers\API;

use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Project;

class ProjectsController extends Controller
{
    public function show(Project $project)
    {
        $this->authorize('update', $project);

        return $project->toJson();
    }

    public function store()
    {
        //validate
        $attributes = $this->validateRequest();

        //persist
        $project = auth()->user()->projects()->create($attributes);

        return response(200);
    }

    protected function validateRequest()
    {
        return request()->validate([
            'title' => 'sometimes|required',
            'description' => 'sometimes|nullable',
            'notes' => 'sometimes|nullable'
        ]);
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
        return response(200);
    }

    public function edit(Project $project)
    {
        $this->authorize('update', $project);

        return response(200);
    }

    public function destroy(Project $project)
    {
        $this->authorize('update', $project);

        $project->delete();

        return response(200);
    }
}
