<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            SuperAdminUserSeeder::class,
            ServiceSeeder::class,
            PostSeeder::class,
            TestimonialSeeder::class,
            TeamMemberSeeder::class,
            PageSeeder::class,
            NavigationItemSeeder::class,
        ]);
    }
}
