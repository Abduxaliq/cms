<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Form;

class FormServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Form::component('bsPassword', 'components.form.password', ['name', 'lblName', 'value'=>null]);
        Form::component('bsText', 'components.form.text', ['name', 'lblName', 'value'=>null, 'attributes'=>[]]);
        Form::component('bsTextPosts', 'components.form.text_posts', ['name', 'lblName', 'value'=>null, 'attributes'=>[]]);
        Form::component('menu', 'components.template.menu', []);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
