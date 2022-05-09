<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $states =
        [
            [
                'id'          => 1,
                'description' => 'PENDIENTE'
            ],
            [
                'id'          => 2,
                'description' => 'CANCELADO'
            ],
            [
                'id'          => 3,
                'description' => 'ENTREGADO'
            ]
        ];

        foreach ($states as $state) {
            $new_state = new \App\Models\State();
            foreach ($state as $key => $value) {
                $new_state->{$key} = $value;
            }

            $new_state->save();
        }
    }
}
