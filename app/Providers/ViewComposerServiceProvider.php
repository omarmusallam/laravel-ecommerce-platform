<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $settings = $this->resolveSettings();
            $user = Auth::user();
            $view->with('configurationData', $settings)->with('user', $user);
        });
    }

    protected function resolveSettings(): Setting
    {
        try {
            return Setting::query()->first() ?: new Setting([
                'name' => config('app.name', 'Laravel'),
                'currency' => config('app.currency', 'ILS'),
                'phone' => '',
                'email' => config('mail.from.address', ''),
                'tax_number' => '',
                'website_logo' => null,
                'epilogue_logo' => null,
                'tab_logo' => null,
                'qr_code' => null,
                'invoice_stamp' => null,
            ]);
        } catch (\Throwable $e) {
            Log::warning('Unable to load shared configuration data.', [
                'message' => $e->getMessage(),
            ]);

            return new Setting([
                'name' => config('app.name', 'Laravel'),
                'currency' => config('app.currency', 'ILS'),
                'phone' => '',
                'email' => config('mail.from.address', ''),
                'tax_number' => '',
                'website_logo' => null,
                'epilogue_logo' => null,
                'tab_logo' => null,
                'qr_code' => null,
                'invoice_stamp' => null,
            ]);
        }
    }
}
