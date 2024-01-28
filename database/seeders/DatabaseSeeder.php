<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Follow;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $userCount = 10;
        $postCountPerUser = 3;

        User::factory($userCount)
            ->has(
                Post::factory()
                        ->count($postCountPerUser)
                        ->state(function (array $attributes, User $user) {
                            return ['user_id' => $user->id];
                        })
            )
            ->create();

        $userIds = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

        foreach ($userIds as $userId) {
            $followCount = fake()->numberBetween(0, 9);

            $randomIndices = [];
            for ($i = 0; $i < $followCount; $i++) {
                $randomIndices[] = array_rand($userIds);
            }

            $followedIds = array_values(Arr::only($userIds, $randomIndices));
            $followedIdsWithoutSelf = array_unique(array_diff($followedIds, [$userId]));

            foreach ($followedIdsWithoutSelf as $followedId) {
                Follow::factory()
                            ->state(function (array $attributes) use ($followedId, $userId) {
                                return [
                                    'followed_id' => $followedId,
                                    'follower_id' => $userId
                                ];
                            })
                            ->create();
            }
        }
    }
}
