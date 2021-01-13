<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index()
    {
        // $faker = \Faker\Factory::create();
        // dd($faker->name);
        $data = [
            'title' => 'Home',
            'tes' => ['satu', 'dua', 'tiga']
        ];
        return view('Pages/Home', $data);
    }
    public function about()
    {
        $data = [
            'title' => 'About'
        ];
        return view('Pages/About', $data);
    }
    public function address()
    {
        $data = [
            'title' => 'OUR ADDRESS',
            'alamat' => [[
                'tipe' => 'Rumah',
                'alamat' => 'Jalan Sidakarya Artayoga No.1',
                'kota' => 'Denpasar'
            ], [
                'tipe' => 'Kantor',
                'alamat' => 'Jalan Muding Sari No.19',
                'kota' => 'Badung'
            ]]
        ];
        return view('Pages/address', $data);
    }
}
