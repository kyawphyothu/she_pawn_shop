<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\HtetYu;
use App\Models\Order;
use App\Models\OrderCategory;
use App\Models\Owner;
use App\Models\Pawn;
use App\Models\Rate;
use App\Models\User;
use App\Models\Village;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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

        // Order::factory(300)->create();

        //user
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ]);

        //interest rate
        Rate::factory()->create([
            'condition' => '<500000',
            'interest_rate' => 0.03,
        ]);
        Rate::factory()->create([
            'condition' => '>=500000',
            'interest_rate' => 0.02,
        ]);

        //orders
        // Order::factory(20)->create();

        //order_categories
        // OrderCategory::factory(50)->create();

        //htetYus
        // HtetYu::factory(50)->create();

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
            'name' => 'နားကပ်'
        ]);
        Category::factory()->create([
            'name' => 'နားကွင်း'
        ]);
        Category::factory()->create([
            'name' => 'နားဆွဲ'
        ]);
        Category::factory()->create([
            'name' => 'လက်စွပ်'
        ]);
        Category::factory()->create([
            'name' => 'ဆွဲကြိုး'
        ]);
        Category::factory()->create([
            'name' => 'ဆွဲပြား/ဆွဲသီး'
        ]);
        Category::factory()->create([
            'name' => 'လက်ကောက်'
        ]);
        Category::factory()->create([
            'name' => 'ဟန်းချိန်း'
        ]);
        Category::factory()->create([
            'name' => 'ကလစ်/ခေါင်းစည်းကြိုး'
        ]);
        Category::factory()->create([
            'name' => 'ကြယ်သီး'
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
            'name' => 'ကျောက်ကုန်း'
        ]);
        Village::factory()->create([
            'name' => 'ကြပ်ကန်'
        ]);
        Village::factory()->create([
            'name' => 'ကြပ်စု'
        ]);
        Village::factory()->create([
            'name' => 'ကံဆောင်'
        ]);
        Village::factory()->create([
            'name' => 'ကျူတော'
        ]);
        Village::factory()->create([
            'name' => 'ကိုင်းတောက်ကန်'
        ]);
        Village::factory()->create([
            'name' => 'ကပဲချောင်း'
        ]);
        Village::factory()->create([
            'name' => 'ကူဖြူ'
        ]);
        Village::factory()->create([
            'name' => 'ကွက်သစ်'
        ]);
        Village::factory()->create([
            'name' => 'ကျွန်းသစ်'
        ]);
        Village::factory()->create([
            'name' => 'ကုန်းသောင်'
        ]);
        Village::factory()->create([
            'name' => 'ချောင်းတက်'
        ]);
        Village::factory()->create([
            'name' => 'ချောင်းပိုက်'
        ]);
        Village::factory()->create([
            'name' => 'ခပေါင်းတဲ'
        ]);
        Village::factory()->create([
            'name' => 'ချောင်းဖီလာ'
        ]);
        Village::factory()->create([
            'name' => 'ချစ်မြစ်ကျွန်း'
        ]);
        Village::factory()->create([
            'name' => 'စစ်ကုန်း'
        ]);
        Village::factory()->create([
            'name' => 'စက်ရုံ'
        ]);
        Village::factory()->create([
            'name' => 'စေတီရပ်'
        ]);
        Village::factory()->create([
            'name' => 'စောင်းတောကန်'
        ]);
        Village::factory()->create([
            'name' => 'စလင်းတောင်'
        ]);
        Village::factory()->create([
            'name' => 'ဆူးပန်းချောင်း'
        ]);
        Village::factory()->create([
            'name' => 'ဆူးပုတ်တန်း'
        ]);
        Village::factory()->create([
            'name' => 'ဆင်မကျွန်း'
        ]);
        Village::factory()->create([
            'name' => 'ဆူးရစ်ကန်'
        ]);
        Village::factory()->create([
            'name' => 'ဇီးခုံ'
        ]);
        Village::factory()->create([
            'name' => 'ဈေး'
        ]);
        Village::factory()->create([
            'name' => 'ဈေးဝိုင်း'
        ]);
        Village::factory()->create([
            'name' => 'ညီးစု'
        ]);
        Village::factory()->create([
            'name' => 'ညောင်ချောင်း'
        ]);
        Village::factory()->create([
            'name' => 'ညောင်ဘွာ'
        ]);
        Village::factory()->create([
            'name' => 'တိုက်ကုန်း'
        ]);
        Village::factory()->create([
            'name' => 'တောင်ကြိတ်စု'
        ]);
        Village::factory()->create([
            'name' => 'တမာတန်း'
        ]);
        Village::factory()->create([
            'name' => 'တောင်ရပ်'
        ]);
        Village::factory()->create([
            'name' => 'ထန်းပင်ခြံ'
        ]);
        Village::factory()->create([
            'name' => 'ထောက်ရှည်ကန်'
        ]);
        Village::factory()->create([
            'name' => 'ဒလင့်ကန်'
        ]);
        Village::factory()->create([
            'name' => 'နဘဲတန်း'
        ]);
        Village::factory()->create([
            'name' => 'ပခန်းငယ်'
        ]);
        Village::factory()->create([
            'name' => 'ပုဂံစု'
        ]);
        Village::factory()->create([
            'name' => 'ပွင့်လင်း'
        ]);
        Village::factory()->create([
            'name' => 'ပွဲစားတန်း'
        ]);
        Village::factory()->create([
            'name' => 'ပြည့်ပင်ရွာ'
        ]);
        Village::factory()->create([
            'name' => 'ဖိုးကုန်း'
        ]);
        Village::factory()->create([
            'name' => 'မြို့ကုန်း'
        ]);
        Village::factory()->create([
            'name' => 'မကျီးကန်'
        ]);
        Village::factory()->create([
            'name' => 'မကျီးချောင်း'
        ]);
        Village::factory()->create([
            'name' => 'မကျီးစောက်'
        ]);
        Village::factory()->create([
            'name' => 'မြောက်ကြိတ်စု'
        ]);
        Village::factory()->create([
            'name' => 'မြေနီကုန်း/ချောက်'
        ]);
        Village::factory()->create([
            'name' => 'မင်းဂံ'
        ]);
        Village::factory()->create([
            'name' => 'မြို့မ'
        ]);
        Village::factory()->create([
            'name' => 'မွှေ့ယာတန်း'
        ]);
        Village::factory()->create([
            'name' => 'မြင်သာကုန်း'
        ]);
        Village::factory()->create([
            'name' => 'ရွာငယ်ကန်'
        ]);
        Village::factory()->create([
            'name' => 'ရဲစခန်း'
        ]);
        Village::factory()->create([
            'name' => 'ရေတွင်း'
        ]);
        Village::factory()->create([
            'name' => 'ရွာသစ်ရပ်'
        ]);
        Village::factory()->create([
            'name' => 'ရွာသစ်ရွာ'
        ]);
        Village::factory()->create([
            'name' => 'ရသစ်ရွာ'
        ]);
        Village::factory()->create([
            'name' => 'ရေလယ်'
        ]);
        Village::factory()->create([
            'name' => 'ရေလယ်ကျွန်း'
        ]);
        Village::factory()->create([
            'name' => 'ရေအရင်းအမြစ်'
        ]);
        Village::factory()->create([
            'name' => 'လွင်ကျယ်ထိန်ကန်'
        ]);
        Village::factory()->create([
            'name' => 'လက်ပံကျွန်းရွာမ/ရွာသစ်'
        ]);
        Village::factory()->create([
            'name' => 'လယ်စိုက်ရှင်း'
        ]);
        Village::factory()->create([
            'name' => 'သုံးဆင့်'
        ]);
        Village::factory()->create([
            'name' => 'သစ်ချိုကုန်း'
        ]);
        Village::factory()->create([
            'name' => 'သစ်ညိုကုန်း'
        ]);
        Village::factory()->create([
            'name' => 'အုံးပွဲတော'
        ]);
        Village::factory()->create([
            'name' => 'အုတ်ဖို'
        ]);
        Village::factory()->create([
            'name' => 'အောက်လယ်'
        ]);
        Village::factory()->create([
            'name' => 'အလယ်ရွာ'
        ]);
        Village::factory()->create([
            'name' => 'ဥယျာဥ်ရွာ'
        ]);
        Village::factory()->create([
            'name' => 'EPCရုံးနား'
        ]);
        Village::factory()->create([
            'name' => '416စစ်တပ်'
        ]);
    }
}
