<?php

use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employees')->insert([
            'pid' => 0,
            'position_id' => 1,
            'full_name' => 'Employee 1',
            'employment_start' => date('Y-m-d'),
            'salary' => 20000,
            'photo' => ''
        ]);

        $employee_count = 1;
        $level_2_ids = [];
        for ($i = 1; $i <= 5; $i++) {
            $employee_count++;
            $level_2_ids[] = DB::table('employees')->insertGetId([
                'pid' => 1,
                'position_id' => 2,
                'full_name' => 'Employee ' . $employee_count,
                'employment_start' => date('Y-m-d'),
                'salary' => 6000,
                'photo' => ''
            ]);
        }

        $level_3_ids = [];
        foreach ($level_2_ids as $pid) {

            for ($i = 1; $i <= 5; $i++) {
                $employee_count++;
                $level_3_ids[] = DB::table('employees')->insertGetId([
                    'pid' => $pid,
                    'position_id' => 3,
                    'full_name' => 'Employee ' . $employee_count,
                    'employment_start' => date('Y-m-d'),
                    'salary' => 5000,
                    'photo' => ''
                ]);
            }

        }

        $level_4_ids = [];
        foreach ($level_3_ids as $pid) {

            for ($i = 1; $i <= 20; $i++) {
                $employee_count++;
                $level_4_ids[] = DB::table('employees')->insertGetId([
                    'pid' => $pid,
                    'position_id' => 4,
                    'full_name' => 'Employee ' . $employee_count,
                    'employment_start' => date('Y-m-d'),
                    'salary' => 4000,
                    'photo' => ''
                ]);
            }

        }

        foreach ($level_4_ids as $pid) {

            for ($i = 1; $i <= 100; $i++) {
                $employee_count++;
                $level_4_ids[] = DB::table('employees')->insertGetId([
                    'pid' => $pid,
                    'position_id' => 5,
                    'full_name' => 'Employee ' . $employee_count,
                    'employment_start' => date('Y-m-d'),
                    'salary' => 2000,
                    'photo' => ''
                ]);
            }

        }
    }
}
