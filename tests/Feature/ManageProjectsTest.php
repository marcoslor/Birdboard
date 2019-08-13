<?php

namespace Tests\Feature;

use App\Project;
use Tests\TestCase;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function guests_cannot_manage_projects(): void
    {
        $project = factory('App\Project')->create();

        $this->get('/projects/create') ->assertRedirect('login');
        $this->get($project->path().'/edit')->assertRedirect('login');
        $this->get('/projects/edit')->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
        $this->post('/projects', $project->toArray())->assertRedirect('login');
    }

    /** @test */
    public function an_authenticated_user_cannot_view_the_projects_of_others(): void
    {
        //Creates user and signs it in
        $this->signIn();
//        $this->withoutExceptionHandling();
        //creates project with user_id
        $project = factory('App\Project')->create();

        $this->get($project->path())->assertForbidden();
    }

    /** @test */
    public function a_project_requires_a_title(): void
    {
        $this->signIn();

        $attributes = factory('App\Project')->raw(['title'=>'']);
        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }


    /** @test */
    public function a_user_can_view_their_project(): void
    {
        $project = ProjectFactory::ownedBy($this->signIn())
            ->withTasks(1)
            ->create();

        $this->get($project->path())->assertSee($project->title)->assertSee(substr($project->description, 0,100));
    }

    /** @test */
    public function a_user_can_create_a_project(): void
    {
        $this->withoutExceptionHandling();
        $this->signIn();


        $this->get('/projects/create')->assertStatus(200);

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph
        ];

        $this->post('/projects', $attributes)->assertRedirect(Project::where($attributes)->first()->path());

        $this->assertDatabaseHas('projects', $attributes);
        $this->get('/projects')->assertSee($attributes['title']);
    }

    /** @test */
    public function a_user_can_delete_a_project(): void
    {
        $this->withoutExceptionHandling();
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)->delete($project->path())->assertRedirect('/projects');

        $this->assertNull($project->fresh());
    }

    /** @test */
    public function guests_cannot_delete_a_project(): void
    {
        //$this->withoutExceptionHandling();
        $project = ProjectFactory::create();

        $this->delete($project->path())->assertRedirect('/login');

        $this->assertNotNull($project->fresh());
    }


    /** @test */
    public function users_can_only_delete_their_projects(): void
    {
        $user = factory('App\User')->create(['id' => 12]);
        //creates project with user_id
        $project = ProjectFactory::ownedBy($user)->create();

        $this->signIn();
        $this->delete($project->path())->assertForbidden();
        $this->assertDatabaseHas('projects', ['id' => $project->id]);
    }

    /** @test */
    public function a_user_can_update_a_project(): void
    {
        $project = ProjectFactory::ownedBy($this->signIn())
            ->create();
        $this->get($project->path().'/edit')->assertOk();
        $this->patch($project->path(), ['title'=>'changed', 'description'=>'changed', 'notes'=>'changed'])->assertRedirect($project->path());
        $this->assertDatabaseHas('projects', ['title'=>'changed', 'description'=>'changed','notes'=>'changed']);
    }

    /** @test */
    public function a_user_can_update_a_projects_general_notes(): void
    {
        $project = ProjectFactory::ownedBy($this->signIn())
            ->create();

        $this->get($project->path().'/edit')->assertOk();
        $this->patch($project->path(), ['notes'=>'changed'])->assertRedirect($project->path());
        $this->assertDatabaseHas('projects', ['notes'=>'changed']);
    }

    /** @test */
    public function an_authenticated_user_cannot_update_others_project(): void
    {
        $this->signIn();
        factory('App\User')->create(['id'=>12]);

        //creates project with user_id
        $project = factory('App\Project')->create(['owner_id'=>12]);

        $this->patch($project->path(), ['notes' => 'changed'])->assertForbidden();
        $this->assertDatabaseMissing('projects', ['notes'=>'changed']);
    }

    /** @test */
    public function a_user_can_see_all_the_projects_they_participate_in(): void
    {
        $invitee = $this->signIn(factory('App\User')->create(['id' => 1]));
        $project = tap(ProjectFactory::ownedBy(factory('App\User')->create(['id' => 2]))->create())
            ->invite($invitee);

        $this->get('/projects')->assertSee($project->title);
    }

}
