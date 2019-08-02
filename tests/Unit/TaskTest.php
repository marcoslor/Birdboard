<?php

namespace Tests\Unit;

use App\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function it_belongs_to_a_project()
    {
        $task = factory('App\Task')->create();
        $this->assertInstanceOf(Project::class, $task->project);
    }

    /** @test */
    public function it_has_a_path()
    {
        $task = factory('App\Task')->create();
        $this->assertEquals('/tasks/'.$task->id, $task->path());
    }

    /** @test */
    public function it_can_be__marked_as_completed()
    {
        $task = factory('App\Task')->create();

        $this->assertFalse($task->fresh()->completed);

        $task->complete();

        $this->assertTrue($task->fresh()->completed);
    }

    /** @test */
    public function it_can_be__marked_as_incomplete()
    {
        $task = factory('App\Task')->create();

        $task->complete();

        $this->assertTrue($task->fresh()->completed);

        $task->incomplete();

        $this->assertFalse($task->fresh()->completed);

    }
}
