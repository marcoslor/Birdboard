<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;
use Facades\Tests\Setup\ProjectFactory;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    function a_user_has_projects(){
//        $this->withoutExceptionHandling();

        $user = factory('App\User')->create();
        $this->assertInstanceOf(Collection::class, $user->projects);
    }

    /** @test */
    public function a_user_has_external_projects()
    {
        $this->withoutExceptionHandling();
        $userA = factory('App\User')->create();
        $userB = factory('App\User')->create();
        $userC = factory('App\User')->create();

        $projectA = ProjectFactory::ownedBy($userA)->create();

        $this->assertCount(0, $userB->avaliableProjects());
        $projectA->invite($userB);
        $this->assertCount(1, $userB->avaliableProjects());

        $projectB = ProjectFactory::ownedBy($userA)->create();
        $projectB->invite($userC);
        $this->assertCount(1, $userB->avaliableProjects());

    }
}
