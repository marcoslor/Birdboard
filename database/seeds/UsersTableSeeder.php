<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        $user1 = factory('App\User')->create(['password' => '$2y$10$z8ux3OyCIUGOYQdXjXHY1.fx7FelEht1UswbXQhf9Gmlz6Z2xO6lu', 'email' => 'email@example.com']);
        factory('App\Project')->create(['owner_id' => $user1]);

        $user2 = factory('App\User')->create(['password' => '$2y$10$z8ux3OyCIUGOYQdXjXHY1.fx7FelEht1UswbXQhf9Gmlz6Z2xO6lu', 'email' => 'aemail@example.com']);

        $user1->projects[0]->invite($user2);
    }
}
