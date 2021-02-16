<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'status' => 'confirmed',
            'dateCreated' => \Carbon\Carbon::now(),
            'dateUpdated' => \Carbon\Carbon::now()
        ]);
    }
}
