<?php

namespace Doker42\Telegramlog;

use Illuminate\Support\ServiceProvider;

class TelegramLogServiceProvider  extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/telegramlog.php',
            'telegramlog'
        );
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/config/telegramlog.php' => config_path('telegramlog.php'),
        ], 'telegramlog');
    }
}
