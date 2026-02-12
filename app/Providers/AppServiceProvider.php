<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (class_exists(\Modules\Clients\Livewire\Index::class)) {
            Livewire::component('clients::index', \Modules\Clients\Livewire\Index::class);
        }
        $this->configureDefaults();
    }

    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null
        );

        //Add By Mac
        //Customize the email verification notification
        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            $mailMessage = new MailMessage;
            // Chiama il metodo buildMailMessage originale
            $reflection = new \ReflectionClass(VerifyEmail::class);
            $method = $reflection->getMethod('buildMailMessage');
            $method->setAccessible(true);
            $notification = new VerifyEmail;
            $mailMessage = $method->invoke($notification, $url);
            // Modifica solo il subject
            return $mailMessage->subject(config('app.name') . ' | Verify Email Address');
        });
    }
}
