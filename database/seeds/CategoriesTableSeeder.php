<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = collect([
            'PHP','Laravel','CSS','C++','React','HTML'
            ]);
        $categories->each(function($c){
            \App\Category::create([
                'name' => $c,
                'slug' => \Str::slug($c),
            ]);
        });
    }
}
