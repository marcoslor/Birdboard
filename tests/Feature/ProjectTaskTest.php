<?php

namespace Tests\Feature;

use App\Project;
use App\Task;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */

    public function a_project_can_have_tasks()
    {
        $project = ProjectFactory::ownedBy($this->signIn())
            ->create();

        $this->post($project->path().'/tasks', ['body'=>'tasktest4']);

        $this->get($project->path())->assertSee('tasktest4');
    }

    /** @test */
    public function a_task_requires_a_body()
    {
        $project = ProjectFactory::ownedBy($this->signIn())
            ->create();
        $attributes = factory('App\Task')->raw(['body'=>'']);
        $this->post($project->path().'/tasks', $attributes)->assertSessionHasErrors('body');
    }

    /** @test */
    public function guests_cannot_add_tasks_to_project()
    {
        $project = ProjectFactory::ownedBy(factory('App\User'))->
        create();

        $task = factory(Task::class)->raw();

        $this->post($project->path().'/tasks', $task)->assertRedirect('login');
        $this->assertDatabaseMissing('tasks', $task);
    }

    /** @test */
    public function only_the_owner_of_a_project_may_add_tasks(){
        $this->signIn();

        $project = factory(Project::class)->create();
        $task = ['body'=>'hehehe'];

        $this->post($project->path().'/tasks', $task)->assertStatus(403);

        $this->assertDatabaseMissing('tasks', $task);
    }

    /** @test */
    public function project_page_after_post_request()
    {
        $this->withoutExceptionHandling();
        $project = ProjectFactory::ownedBy($this->signIn())
            ->withTasks(1)
            ->create();
        $task = ['body'=>'hehehe'];
        $this->post($project->path().'/tasks', $task)->assertRedirect($project->path());
    }

    /** @test */
    public function a_task_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $project = ProjectFactory::ownedBy($this->signIn())
            ->withTasks(1)
            ->create();

        $this->patch($project->tasks->first()->path(),[
            'body'=>'changed'
        ]);

        $this->assertDatabaseHas('tasks',[
            'body'=>'changed'
        ]);
    }

    /** @test */
    public function a_task_can_be_marked_as_completed()
    {
        $project = ProjectFactory::ownedBy($this->signIn())
            ->withTasks(1)
            ->create();

        $this->patch($project->tasks->first()->path(),[
            'body'=>'changed',
            'completed'=>true
        ]);

        $this->assertDatabaseHas('tasks',[
            'body'=>'changed',
            'completed'=>true
        ]);
    }

    /** @test */
    public function a_task_can_be_marked_as_incomplete()
    {
        $project = ProjectFactory::ownedBy($this->signIn())
            ->withTasks(1)
            ->create();

        $this->patch($project->tasks->first()->path(),[
            'body'=>'changed',
            'completed'=>true
        ]);

        $this->patch($project->tasks->first()->path(),[
            'body'=>'changed',
            'completed'=>false
        ]);

        $this->assertDatabaseHas('tasks',[
            'body'=>'changed',
            'completed'=>false
        ]);
    }

    /** @test */
    public function only_the_owner_of_a_project_may_update_tasks(){
        $user = $this->signIn();

        $project = factory(Project::class)->create();
        $task = $project->addTask('test task');

        $this->patch($task->path(), ['body'=>'changed'])->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body'=>'changed']);
    }
}
