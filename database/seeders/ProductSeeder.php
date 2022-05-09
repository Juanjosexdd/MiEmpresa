<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products =
        [
            [
                'id'            => 1,
                'name'          => 'A lo pobre',
                'description'   => 'Carne, huevo, maduro, queso, salsa anticuchera y sarza criolla',
                'available'     => 1,
                'price'         => '14.00',
                'image'         => 'alopobre.jpg',
                'status'        => 1
            ],

            [
                'id'            => 2,
                'name'          => 'Bacon',
                'description'   => 'Carne, queso edam y abundante tocino',
                'available'     => 1,
                'price'         => '13.00',
                'image'         => 'bacon.jpg',
                'status'        => 1
            ],

            [
                'id'            => 3,
                'name'          => 'Cheese',
                'description'   => 'Carne, queso edam, cheddar y madurado',
                'available'     => 1,
                'price'         => '13.00',
                'image'         => 'cheese.jpg',
                'status'        => 1
            ],

            [
                'id'            => 4,
                'name'          => 'La de siempre',
                'description'   => 'Carne, lechuga y tomate',
                'available'     => 1,
                'price'         => '14.00',
                'image'         => 'ladesiempre.jpg',
                'status'        => 1
            ],
            

            [
                'id'            => 5,
                'name'          => 'La explosiva',
                'description'   => 'Doble Carne, lechuga y tomate',
                'available'     => 1,
                'price'         => '18.00',
                'image'         => 'ladesiempre.jpg',
                'status'        => 1
            ],
        ];


        foreach($products as $product)
        {
            $new_product = new \App\Models\Product();
            foreach($product as $k => $value)
            {
                $new_product->{$k} = $value;
            }

            $new_product->save();
        }
    }
}
