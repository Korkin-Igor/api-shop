<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            'name' => 'Product name 1',
            'description' => 'Product description 1',
            'price' => 100,
        ]);

        DB::table('products')->insert([
            'name' => 'Product name 2',
            'description' => 'Product description 2',
            'price' => 200,
        ]);
    }
}
