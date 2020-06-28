<?php

use App\Position;
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
        Position::create([
            'name' => Position::$PHF,
            'description' => 'Phf'
        ]);
        Position::create([
            'name' => Position::$DG,
            'description' => 'Director General'
        ]);
        Position::create([
            'name' => Position::$DG,
            'description' => 'Director General'
        ]);
        Position::create([
            'name' => Position::$DGCPHS,
            'description' => 'Director general of clinical services'
        ]);
        Position::create([
            'name' => Position::$DHPRU,
            'description' => Position::$DHPRU,
        ]);
        Position::create([
            'name' => Position::$MOS,
            'description' => Position::$MOS,
        ]);
        Position::create([
            'name' => Position::$MINISTER,
            'description' => Position::$MINISTER,
        ]);
        Position::create([
            'name' => Position::$PS,
            'description' => 'Permanent secretary',
        ]);
        Position::create([
            'name' => Position::$DGP,
            'description' => 'Director general of planning',
        ]);
    }
}
