<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        Setting::query()->updateOrCreate(
            ['email' => 'sales@digital-hub.test'],
            [
                'name' => 'ديجيتال هب',
                'currency' => 'USD',
                'phone' => '+1 202 555 0187',
                'email' => 'sales@digital-hub.test',
                'tax_number' => 'US-DH-2026-1001',
                'website_logo' => 'settings/website-logo.png',
                'epilogue_logo' => 'settings/epilogue-logo.png',
                'tab_logo' => 'settings/tab-logo.png',
                'qr_code' => 'settings/qr-code.png',
                'invoice_stamp' => 'settings/invoice-stamp.png',
            ]
        );
    }
}
