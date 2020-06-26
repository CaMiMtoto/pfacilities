<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $position = \App\Position::create(
            [
                'name' => 'Admin',
                'description' => 'System Administrator',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
        \App\User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'phone' => '0780661813',
            'email_verified_at' => now(),
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => \App\Roles::$ADMIN,
            'position_id' => $position->id,
        ]);
    }
}
