<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\User;
use App\Models\Subscriber;
use App\Models\Newsletter;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        Subscriber::factory(10)->create();
        Newsletter::factory(10)->create();
        Campaign::factory(10)->create();
    }
}
