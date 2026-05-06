<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@tahanan.local'],
            [
                'name' => 'Admin',
                'password' => bcrypt('Admin12345!'),
            ]
        );

        $this->call([
            TahananSeeder::class,
        ]);
    }
}
