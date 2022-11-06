<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\OrderStatus::create([
            'name' => 'جديد'
        ]);  
        \App\Models\OrderStatus::create([
            'name' => 'قيد العمل'
        ]);  
        \App\Models\OrderStatus::create([
            'name' => 'تم الارسال'
        ]);    
        \App\Models\OrderStatus::create([
            'name' => 'تم التسليم'
        ]);  
        \App\Models\OrderStatus::create([
            'name' => 'ملغي'
        ]);  
    }
}
