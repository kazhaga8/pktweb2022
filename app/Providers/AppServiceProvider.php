<?php

namespace App\Providers;

use App\Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $app = [];
        $config = Config::get()->toArray()[0];
        foreach ($config as $key => $value) {
            $app['app.'.$key] = $value;
        }
        config(array_merge(['app.locale' => 'id'], $app));
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');

        Blade::include('webmin.component.componentlib', 'componentlib');
        Blade::include('webmin.component.input', 'input');
        Blade::include('webmin.component.select', 'select');
        Blade::include('webmin.component.select2', 'select2');
        Blade::include('webmin.component.radio', 'radio');
        Blade::include('webmin.component.checkbox', 'checkbox');
        Blade::include('webmin.component.textarea', 'textarea');
        Blade::include('webmin.component.texteditor', 'texteditor');
        Blade::include('webmin.component.inputfile', 'inputfile');
        Blade::include('webmin.component.datepicker', 'datepicker');
        Blade::include('webmin.component.datepickerrange', 'datepickerrange');
        Blade::include('webmin.component.datetimepickerrange', 'datetimepickerrange');

        //
    }
}
