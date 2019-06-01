<?php

use App\Reply;
use App\Thread;
use Illuminate\Database\Seeder;

class ThreadsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $threads = factory(Thread::class, 50)->create();

        $threads->each(function ($thread) {
            factory(Reply::class, 10)->create(['thread_id' => $thread->id]);
        });
    }
}
