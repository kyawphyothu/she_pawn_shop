<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use App\Models\Owner;
use App\Models\Pawn;
use App\Models\Village;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Order::factory(50)->create();

        //owner
        Owner::factory()->create([
            'name' => 'အိမ်'
        ]);
        Owner::factory()->create([
            'name' => 'အေးအေးခိုင်'
        ]);
        Owner::factory()->create([
            'name' => 'စန်းစန်းထွေး'
        ]);
        Owner::factory()->create([
            'name' => 'ဥမ္မာဝင်း'
        ]);

        //category
        Category::factory()->create([
            'name' => 'ဆံညှပ်'
        ]);
        Category::factory()->create([
            'name' => 'နားကပ်'
        ]);
        Category::factory()->create([
            'name' => 'နားတောင်း'
        ]);
        Category::factory()->create([
            'name' => 'နားဆွဲ'
        ]);
        Category::factory()->create([
            'name' => 'လက်ကောက်'
        ]);
        Category::factory()->create([
            'name' => 'လက်စွပ်'
        ]);
        Category::factory()->create([
            'name' => 'ဆွဲကြိုး'
        ]);

        //pawns
        Pawn::factory()->create([
            'value' => 'မရွေးရသေး'
        ]);
        Pawn::factory()->create([
            'value' => 'ရွေးပြီး'
        ]);

        //village
        Village::factory()->create([
            'name' => 'ရွာသစ်'
        ]);
        Village::factory()->create([
            'name' => 'မြို့မ'
        ]);
        Village::factory()->create([
            'name' => 'ဈေး'
        ]);
        Village::factory()->create([
            'name' => 'စက်ရုံ'
        ]);
        Village::factory()->create([
            'name' => 'သစ်ချိုကုန်း'
        ]);
    }
}
