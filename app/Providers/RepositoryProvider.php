<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    private array $repositories = [
        'LivroRepository',
        'AssuntoRepository',
        'AutorRepository',
        'LivroAutorRepository',
        'LivroAssuntoRepository',
        'AutorReportRepository'
    ];

    public function register(): void
    {
        foreach ($this->repositories as $repository) {
            $this->app->bind(
                "App\\Repositories\Interfaces\\I{$repository}",
                "App\\Repositories\\{$repository}",
            );
        }
    }
}
