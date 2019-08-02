<?php

namespace Tests\Feature;

use App\Project;
use App\Task;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TriggerActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function creating_a_project(): void
    {
        $project = factory('App\Project')->create();

        $this->assertCount(1, $project->activity);
        $this->assertEquals('created_project', $project->activity[0]->description);

        tap($project->activity->last(), function ($activity){
            $this->assertNull($activity->changes);
        });

    }

    /** @test */
    public function updating_a_project(): void
    {
        $project = factory('App\Project')->create();

        $original = $project->title;

        $project->update(['title'=>'changed']);

        $this->assertCount(2, $project->activity);

        tap($project->activity->last(), function ($activity) use ($original){
            $this->assertEquals('updated_project', $activity->description);

            $expected = [
                'before' => ['title' => $original],
                'after' => ['title' => 'changed']
            ];

            $this->assertEquals($expected,$activity->changes);
        });

    }

    /** @test */
    public function creating_a_new_task(): void
    {
        $project = factory('App\Project')->create();

        $project->addTask('Some Task');

        $this->assertCount(2, $project->activity);

        tap($project->activity->last(), function ($activity){
            $this->assertEquals('created_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
            $this->assertEquals('Some Task', $activity->subject->body);

        });
    }

    /** @test */
    public function completing_a_task(): void
    {
        $this->withoutExceptionHandling();

        $project = factory('App\Project')->create();
        $project->addTask('Some Task');

        $this->actingAs($project->owner)->patch($project->tasks[0]->path(), [
            'body' => 'changed',
            'completed' => true
        ]);

        $this->assertCount(3, $project->fresh()->activity);

        tap($project->activity->last(), function ($activity){
            $this->assertEquals('completed_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
        });}

    /** @test */
    public function incompleting_a_task(): void
    {
        $this->withoutExceptionHandling();
        $project = factory('App\Project')->create();
        $project->addTask('Some Task');

        $this->assertCount(2, $project->activity);
        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(),
                [
                    'body' => 'another body',
                    'completed' => true
                ]);

        $project->refresh();

        $this->assertCount(3, $project->activity);

        $this->actingAs($project->owner)->patch($project->tasks[0]->path(),[
            'body' => 'changed',
            'completed' => false
        ]);
        $project->refresh();

        $this->assertCount(4, $project->activity);
        $this->assertEquals('incompleted_task', $project->activity->last()->description);
    }

    /** @test */
    public function deleting_a_task(): void
    {
        $this->withoutExceptionHandling();
        $project = factory('App\Project')->create();
        $project->addTask('Some Task');

        $project->tasks->last()->delete();

        $this->assertCount(3, $project->activity);
        $this->assertEquals('deleted_task', $project->activity->last()->description);
    }
}
