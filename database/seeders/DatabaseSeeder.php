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
        // \App\Models\User=>:factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        \App\Models\Story::create([
            'title' => 'Test User',
            'author' => 'test1',
            'pages' => [
                (object) array(
                    array(
                        "num" => 1, "img" => "https://images.squarespace-cdn.com/content/v1/5493706de4b0ecaa4047b871/136e2142-c2ef-453c-ab9a-a814af557a85/page+1+copy.jpg?format=1000w", "text" => "I’ve decided I’m moving. I’m running away. I’m bored of this room and I’d rather not stay. The best place to live for a girl such as me, Is space, with no rules, and no grav-ity.",
                    ),

                    array(
                        "num" => 2, "img" => "https://images.squarespace-cdn.com/content/v1/5493706de4b0ecaa4047b871/b3401fd3-750a-4d4a-8a86-3220387fd72f/page+2+copy.jpg?format=1000w", "text" => "My cat Bill and I will need astronaut suits. Our feet will be fine if we take some snow boots."
                    )
                )


            ],
        ]);
    }
}
