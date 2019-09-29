<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ProjectFactory;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */

    public function it_has_a_user(): void
    {
        $user = $this->signIn();

        $project = ProjectFactory::ownedBy($user)->create();

        $this->assertEquals($user->id, $project->activity[0]->user->id);
    }
}
