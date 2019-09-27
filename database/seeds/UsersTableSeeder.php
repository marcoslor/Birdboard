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
        $user1 = factory('App\User')->create(['password' => '$2y$10$C4dWErMl3w2Armmm4E8aJuVJfKnw1AhsUfR.kFif2Ab7hgi1o0/Hq', 'email' => 'email@example.com']);
        factory('App\Project')->create(['owner_id' => $user1]);

        $user2 = factory('App\User')->create(['password' => '$2y$10$C4dWErMl3w2Armmm4E8aJuVJfKnw1AhsUfR.kFif2Ab7hgi1o0/Hq', 'email' => 'aemail@example.com']);

        $user1->projects[0]->invite($user2);
    }
}
