<?php

namespace App\Providers;

use App\Models\Setting;
use App\Services\CurrencyConverter;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // override path_public 
        if (App::environment('production')) {
            $this->app->bind('path_public', function () {
                return base_path('public_html');
            });
        }

        $this->app->bind('currency.converter', function () {
            return new CurrencyConverter(config('services.currency_converter.api_key'));
        });

        $this->app->bind('stripe.client', function () {
            return new \Stripe\StripeClient(config('services.stripe.secret_key'));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        JsonResource::withoutWrapping();

        Paginator::useBootstrapFour();

        $settings = $this->resolveSettings();
        $user = Auth::user();

        view()->share('user', $user);
        view()->share('settings', $settings);

        // Validator::extend('filter', function($attribute, $value, $params) {
        //     return ! in_array(strtolower($value), $params);
        // }, 'The value is prohipted!');
    }

    protected function resolveSettings(): Setting
    {
        try {
            return Setting::query()->first() ?: new Setting($this->defaultSettings());
        } catch (\Throwable $e) {
            Log::warning('Unable to load application settings during boot.', [
                'message' => $e->getMessage(),
            ]);

            return new Setting($this->defaultSettings());
        }
    }

    protected function defaultSettings(): array
    {
        return [
            'name' => config('app.name', 'Laravel'),
            'currency' => config('app.currency', 'USD'),
            'phone' => '',
            'email' => config('mail.from.address', ''),
            'tax_number' => '',
            'website_logo' => null,
            'epilogue_logo' => null,
            'tab_logo' => null,
            'qr_code' => null,
            'invoice_stamp' => null,
        ];
    }
}
