<?php

namespace App\Providers;

use App\Models\TasklistModel;
use App\Models\TaskModel;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Schema;
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

        if (Schema::hasTable('tasks')) {
            $taskNameGlobal = TaskModel::select(['name', 'tasklist_id'])
                ->where('is_running', '1')->first();
    
            if ($taskNameGlobal) {
                $listNameGlobal = TasklistModel::select('name')
                    ->where('id', $taskNameGlobal->tasklist_id)
                    ->first();
            }

            View::share([
                'taskNameGlobal' => $taskNameGlobal->name ?? "",
                'listNameGlobal' => $listNameGlobal->name ?? "",
            ]);
        }
    }
}
