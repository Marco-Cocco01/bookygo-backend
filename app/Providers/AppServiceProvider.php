<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Policies\ClientsPolicy;
use App\Services\MenuServices;
use Livewire\Livewire;
use Laravel\Fortify\Contracts\RegisterResponse;
use App\Http\Responses\CustomRegisterResponse;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(RegisterResponse::class, CustomRegisterResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (class_exists(\Modules\Clients\Livewire\Index::class)) {
            Livewire::component('clients::index', \Modules\Clients\Livewire\Index::class);
        }

        View::composer('*', function ($view) {
            if (Auth::check()) {
                $view->with('menuModules', app(MenuServices::class)->getMenuForUser());
            }
        });
        
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
        /*
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
        */
        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage)
                ->subject(config('app.name') . ' | Verify Email Address')
                ->greeting("Ciao {$notifiable->name}!")
                ->line('Grazie per esserti registrato. Clicca il pulsante qui sotto per verificare il tuo indirizzo email.')
                ->action('Verifica Email', $url)
                ->line('Se non hai creato tu questo account, puoi ignorare questa email.');
        });
    }
}
