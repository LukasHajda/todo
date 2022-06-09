<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usernames = ['Jim', 'Rohit', 'Dayna', 'Kaeden', 'Krystal'];

        foreach ($usernames as $username) {
            if (!User::where('username', $username)->count() > 0) {
                DB::table('users')->insert([
                    'username' => $username,
                    'email' => strtolower($username) . '@gmail.com',
                    'password' => bcrypt('password'),
                    'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
            }
        }
    }
}
