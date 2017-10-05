<?php

use Illuminate\Database\Seeder;

class PositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('positions')->insert(
            array(
                [
                    'position' => 'Chief Executive Officer'
                ],
                [
                    'position' => 'Project Manager'
                ],
                [
                    'position' => 'Team Lead'
                ],
                [
                    'position' => 'Senior Developer'
                ],
                [
                    'position' => 'Middle Developer'
                ]
            )
        );
    }
}
