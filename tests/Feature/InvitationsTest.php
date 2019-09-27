<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ProjectFactory;


class InvitationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_a_projects_owner_can_invite_a_user(): void
    {
        $project = ProjectFactory::create();

        $userToInvite = factory(User::class)->create();

        $this->actingAs($project->owner)->post($project->path() . '/invitations', [
            'email' => $userToInvite->email
        ])->assertRedirect($project->path());

        $this->assertEquals($userToInvite->email, tap($project)->get()->members->first()->email);
    }

    /** @test */
    public function a_user_cannot_be_included_as_member_twice(): void
    {
        $project = ProjectFactory::create();

        $project->invite($anotherUser = factory('App\User')->create());
        $project->invite($anotherUser);

        $project = tap($project)->get();
        $this->assertCount(1, $project->members);
    }

    /** @test */
    public function non_owners_may_not_invite_users(): void
    {
//        $this->withoutExceptionHandling();

        $project = ProjectFactory::create();
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->post($project->path() . '/invitations', ['email' => factory(User::class)->create()->email])
            ->assertForbidden();

        $project->invite($user);

        $this->actingAs($user)
            ->post($project->path() . '/invitations')
            ->assertForbidden();
    }

    /** @test */
    public function an_invited_user_may_update_the_project_details(): void
    {
        $this->withoutExceptionHandling();
        $project = ProjectFactory::create();

        $project->invite($anotherUser = factory('App\User')->create());

        $this->signIn($anotherUser);
        $this->post(action('ProjectTasksController@store', $project), $task = ['body' => 'a task foo']);

        $this->assertDatabaseHas('tasks', $task);
    }

    /** @test */
    public function the_email_must_be_associated_with_a_valid_account(): void
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->post($project->path() . '/invitations',
                [
                    'email' => '100101@example.com'
                ]
            )->assertSessionHasErrors(['email' => __('projects.invitation.no_user')]);
    }

    /** @test */
    public function users_cannot_invite_themselves(): void
    {
        $project = ProjectFactory::create();

        $project->invite(factory(User::class)->create());

        $this->actingAs($project->owner)
            ->post($project->path() . '/invitations',
                [
                    'email' => $project->owner->email
                ]
            )->assertSessionHasErrors();
    }
}
