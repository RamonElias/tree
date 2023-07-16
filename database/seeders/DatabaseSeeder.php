<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Node;
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

        Node::factory()->create([
            'parent' => null,
            'title' => 'one',
        ]);

        Node::factory()->create([
            'parent' => 1,
            'title' => 'two',
        ]);

        Node::factory()->create([
            'parent' => 1,
            'title' => 'three',
        ]);

        // for ($i = 4; $i <= 960; $i++) {
        for ($i = 4; $i <= 769; $i++) {
            $random_parent = rand(1, $i - 1);

            Node::factory()->create([
                'parent' => $random_parent,
                'title' => get_string_from_number($i),
            ]);
        }
    }
}
