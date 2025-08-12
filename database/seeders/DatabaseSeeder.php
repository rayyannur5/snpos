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
            'name' => 'Superuser',
            'username' => 'superuser',
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

        Level::create([
            'id' => 3,
            'name' => 'HRD',
        ]);

        Level::create([
            'id' => 4,
            'name' => 'Finance',
        ]);

        Level::create([
            'id' => 5,
            'name' => 'Technician',
        ]);

        Level::create([
            'id' => 6,
            'name' => 'Operator',
        ]);

        Module::create([
           'id' => 1,
           'ordinal' => 99,
           'parent' => 0,
           'icon' => 'fas fa-user',
           'name' => 'User & Roles',
        ]);

        Module::create([
            'id' => 2,
            'ordinal' => 1,
            'parent' => 1,
            'name' => 'Users',
            'path' => '/userroles/users'
        ]);

        Module::create([
            'id' => 3,
            'ordinal' => 2,
            'parent' => 1,
            'name' => 'Levels',
            'path' => '/userroles/levels'
        ]);

        Module::create([
            'id' => 4,
            'ordinal' => 3,
            'parent' => 1,
            'name' => 'Modules',
            'path' => '/userroles/modules'
        ]);

    }
}
