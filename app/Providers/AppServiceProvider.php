<?php

namespace App\Providers;

use App\Models\TasklistModel;
use App\Models\TaskModel;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
    public function boot(UrlGenerator $url): void
    {
        if (env('APP_ENV') == 'production') {
            $url->forceScheme('https');
        }

        $taskGlobal = TaskModel::where('is_running', '1')->first();
        
        if ($taskGlobal) {
            $listGlobal = TasklistModel::where('id', $taskGlobal->tasklist_id)->first();
        }

        View::share([
            'taskNameGlobal' => $taskGlobal->name ?? "",
            'listNameGlobal' => $listGlobal->name ?? "",
        ]);
    }
}
