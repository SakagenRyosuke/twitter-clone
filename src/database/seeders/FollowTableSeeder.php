<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Follow;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class FollowTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 50; $i++) {
          for($j = 1; $j <=50; $j++){
            if($i == $j) {
              continue;
            }
            Follow::create([
                'followingId'  => $i,
                'followedId' => $j,
            ]);
          }
        }
    }
}
