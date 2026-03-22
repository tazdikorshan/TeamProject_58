<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        // 1. Seed base users
        $this->call([
            UsersTableSeeder::class,
        ]);

        // 2. Admin User (safely upserts without duplicating)
        User::updateOrCreate(
            ['email' => 'admin@homedome.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('Admin123'),
                'is_admin' => true,
                'must_change_password' => true,
            ]
        );

        // 3. Products & Categories
        $this->call([
            ProductSeeder::class,
        ]);

        // 4. Reviews
        $this->call([
            ReviewsTableSeeder::class,
        ]);

        Schema::enableForeignKeyConstraints();
    }
}