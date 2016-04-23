<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Inserting a User ...');
        User::create(array(
            'email' => 'test@teknolohiya.ph',
            'password' => Hash::make('pw1234'),
            'user_type' => 2
        ));
        $this->command->info('User table seeded ...');
    }
}
