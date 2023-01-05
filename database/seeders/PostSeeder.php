<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use Illuminate\Support\Facades\Http;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $posts = Http::get('https://jsonplaceholder.typicode.com/posts')->json();

          foreach ($posts as $key => $value) {
             Post::create([
                "userId" => $value['userId'],
                "title" => $value['title'],
                "body" => $value['body'],
            ]);
        }



    }
}
