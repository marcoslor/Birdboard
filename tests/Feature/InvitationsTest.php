<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ProjectFactory;


class InvitationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_project_can_invite_a_user(): void
    {
        $this->withoutExceptionHandling();
        $project = ProjectFactory::create();

        $project->invite($anotherUser = factory('App\User')->create());

        $this->signIn($anotherUser);
        $this->post(action('ProjectTasksController@store', $project), $task = ['body' => 'a task foo']);

        $this->assertDatabaseHas('tasks', $task);
    }
}
