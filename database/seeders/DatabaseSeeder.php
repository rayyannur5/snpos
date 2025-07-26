<?php

namespace Database\Seeders;

use App\Models\Level;
use App\Models\Module;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'level' => 1
        ]);

        Level::create([
            'id' => 1,
            'name' => 'Super User',
        ]);

        Level::create([
            'id' => 2,
            'name' => 'Owner',
        ]);

        Module::create([
            'id' => 1,
            'ordinal' => 2,
            'parent' => 0,
            'icon' => 'fas fa-address-book',
            'name' => 'Accounting',
        ]);

        Module::create([
           'id' => 2,
           'ordinal' => 2,
           'parent' => 0,
           'icon' => 'fas fa-user',
           'name' => 'User & Roles',
        ]);

        Module::create([
            'id' => 3,
            'ordinal' => 1,
            'parent' => 2,
            'name' => 'Users',
            'path' => '/user&roles/users'
        ]);

        Module::create([
            'id' => 4,
            'ordinal' => 2,
            'parent' => 2,
            'name' => 'Levels',
            'path' => '/user&roles/levels'
        ]);

        Module::create([
            'id' => 5,
            'ordinal' => 3,
            'parent' => 2,
            'name' => 'Modules',
            'path' => '/user&roles/modules'
        ]);

    }
}
