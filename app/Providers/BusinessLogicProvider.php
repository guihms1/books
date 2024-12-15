<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BusinessLogicProvider extends ServiceProvider
{
    private array $services = [
        'LivroService',
        'AssuntoService',
        'AutorService',
        'AutorReportService',
    ];

    public function register(): void
    {
        foreach ($this->services as $service) {
            $this->app->bind(
                "App\\Services\Interfaces\\I{$service}",
                "App\\Services\\{$service}",
            );
        }
    }
}
