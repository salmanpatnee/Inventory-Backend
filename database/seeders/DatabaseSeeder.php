<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Salman',
            'email' => 'salmanpatni92@gmail.com',
            'password' => 'password'
        ]);

        \App\Models\Employee::factory(10)->create();
        \App\Models\Supplier::factory(10)->create();
        \App\Models\Category::factory()->create([
            'name' => 'Uncategorized'
        ]);
        \App\Models\Product::factory(10)->create();
        \App\Models\Expense::factory(5)->create();
        \App\Models\Customer::factory()->create([
            'name' => 'Walk-In Customer',
            'email' => '',
            'phone' => '',
            'address' => '',
        ]);
    }
}
