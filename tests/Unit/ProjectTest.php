<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_path()
    {
        $project = factory('App\Project')->create();
        $this->assertEquals('/projects/' . $project->id, $project->path());
    }

    /** @test */
    public function it_belongs_to_an_owner()
    {
        $project = factory('App\Project')->create();

        $this->assertInstanceOf('App\User', $project->owner);
    }

    /** @test */
    public function it_can_have_a_task()
    {
        $this->signIn();
        $project = factory('App\Project')->create(['owner_id'=>auth()->id()]);
        $task = $project->addTask('tasktest4');
        $this->assertCount(1,$project->tasks);
        //assert that contains task
        $this->assertTrue($project->tasks->contains($task));
    }

    /** @test */
    public function it_can_invite_a_user()
    {
        $this->withoutExceptionHandling();
        $project = factory('App\Project')->create();

        $project->invite($user = factory(User::class)->create());

        $this->assertTrue($project->members->contains($user));
    }

}
