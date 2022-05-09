<?php

namespace Database\Seeders;

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
        $users = 
        [
            [
                'id'        => 1,
                'name'      => 'admin',
                'password'  => bcrypt('admin123.')
            ],
        ];

        foreach($users as $user)
        {
            $new_user = new \App\Models\User();
            foreach($user as $k => $value)
            {
                $new_user->{$k} = $value;
            }
            $new_user->save();
        }
    }
}
