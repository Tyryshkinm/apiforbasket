<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'id' => 1,
            'name' => 'Vape Device',
            'description' => 'Vape Device is handheld electronic device that try to create a feeling like smoking tobacco. They work by heating a liquid to generate an aerosol, commonly called a vapor, that the user inhales.',
            'price' => 14999,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('products')->insert([
            'id' => 2,
            'name' => 'Fidget Spinner',
            'description' => 'A fidget spinner is a toy that consists of a bearing in the center of a multi-lobed flat structure made from metal or plastic designed to spin along its axis with little effort.',
            'price' => 10,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('products')->insert([
            'id' => 3,
            'name' => 'Hoverboard',
            'description' => 'Hoverboard is a self-balancing personal transporter consisting of two motorised wheels connected to a pair of articulated pads on which the rider places their feet.',
            'price' => 29999,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
