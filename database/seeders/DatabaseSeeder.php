<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //\App\Models\User::factory(10)->create();
        //\App\Models\Category::factory(5)->create();
        //\App\Models\Product::factory(22)->create();
       // $this->call(OrderStatusSeeder::class);
        //$this->call(ServiceSeeder::class);
        $this->call(RolesSeeder::class);
    
    }
}
