<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        User::create([
            'name' => 'user',
            'age' => 12,
        ]);

        Admin::create([
            'password' => ('123@Ahmed'),
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'phone' => '01067214731',
            'status' => 1,
        ]);
    }
}
