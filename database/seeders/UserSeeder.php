<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->id_mitra = '014';
        $user->user_id_ntb = 'ummat';
        $user->user_secret = 'ummat';
        $user->secret_key = 'ntb@ts1';
        $user->id_product = '002';
        $user->save();
    }
}
