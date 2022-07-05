<?php

namespace Database\Seeders;

use App\Models\Tweet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TweetTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 50; $i++) {
            Tweet::create([
                'userId'    => $i,
                'text'       => 'これはテスト投稿' . $i,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
