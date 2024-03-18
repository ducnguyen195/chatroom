<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\RoomChat;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        for($i=1; $i<= 5; $i++){
            User::create([
                'name' => 'User ' . $i,
                'email' => 'user' . $i . '@gmail.com',
                'password' => bcrypt('123456789')]);
        }
        for($i=1; $i<= 5; $i++){
            RoomChat::create([
                'name' => 'Room ' . $i,
                'icon' => '/images/avatar.jpg',
                'description' => 'Chat for all',
                'owner_id' => $i
            ]);
        }
    }
}
