<?php

use Illuminate\Database\Seeder;

class PositionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Position::create([
            'name' => \App\Position::$PHF,
            'description' => 'Phf'
        ]);
        \App\Position::create([
            'name' => \App\Position::$DG,
            'description' => 'Director General'
        ]);
    }
}
