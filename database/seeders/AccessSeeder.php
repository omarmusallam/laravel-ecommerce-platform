<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Profile;
use App\Models\Store;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AccessSeeder extends Seeder
{
    public function run(): void
    {
        $primaryStore = Store::query()->first();

        $admin = Admin::query()->create([
            'name' => 'Store Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'phone_number' => '0591111111',
            'super_admin' => true,
            'status' => 'active',
            'store_id' => $primaryStore?->id,
        ]);

        Profile::query()->create([
            'admin_id' => $admin->id,
            'image' => null,
            'first_name' => 'Store',
            'last_name' => 'Admin',
            'birthday' => now()->subYears(30)->toDateString(),
            'gender' => 'male',
            'street_address' => 'Main Street 1',
            'city' => 'Gaza',
            'state' => 'Gaza',
            'postal_code' => '00000',
            'country' => 'PS',
            'locale' => 'ar',
        ]);

        $users = User::factory()
            ->count(8)
            ->create([
                'store_id' => $primaryStore?->id,
                'type' => 'user',
            ]);

        $demoUser = User::query()->create([
            'name' => 'Demo User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'phone_number' => '0592222222',
            'email_verified_at' => now(),
            'store_id' => $primaryStore?->id,
            'type' => 'user',
        ]);

        $users->push($demoUser);

        foreach ($users as $index => $user) {
            UserProfile::query()->create([
                'user_id' => $user->id,
                'first_name' => "User{$index}",
                'last_name' => 'Customer',
                'birthday' => now()->subYears(rand(18, 45))->toDateString(),
                'gender' => $index % 2 === 0 ? 'male' : 'female',
                'street_address' => 'Customer Street',
                'city' => 'Gaza',
                'state' => 'Gaza',
                'postal_code' => '00000',
                'country' => 'PS',
                'locale' => 'ar',
                'profile_photo_path' => null,
            ]);
        }
    }
}
