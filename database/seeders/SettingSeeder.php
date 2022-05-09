<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = 
        [
            [
                'id'            => 1,
                'logo_home'     => 'logo_home.jpg',
                'logo_shop'     => 'logo_gueros_shop.png',
                'logo_footer'   => 'logo_gueros_footer.png',
                'phone'         => '04125205105',
                'url_fb'        => 'https://www.facebook.com/juanjosexdd',
                'url_insta'     => '',
                'url_maps'      => 'https://goo.gl/maps/6TLdC2MLzuq4kacY8',
                'yape'          => '950772205',
                'plin'          => '950772205',
                'transferencia' => '4271254845987452',
                'address'       => 'Av. 29 Entre calle 37 y 38 Andres Bello, Acarigua Edo. Portuguesa.',
                'name_company'  => 'Mi Empresa'
            ]
        ];

        foreach($settings as $setting)
        {
            $new_setting = new \App\Models\Setting();
            foreach ($setting as $key => $value) 
            {
                $new_setting->{$key} = $value;
            }

            $new_setting->save();
        }

    }
}
