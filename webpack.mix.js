const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.sass('resources/assets/sass/style.scss', 'public/assets')
    .sass('resources/assets/sass/login.scss', 'public/assets')

    // ******************** Web frontend ********************
    .styles([
        'resources/assets/frontend/css/bootstrap.min.css',

        'public/assets/style.css'
    ], 'public/css/style.min.css')

    .scripts([
        'resources/assets/frontend/js/jquery.min.js',
        'resources/assets/frontend/js/jquery-3.5.1.min.js',
        'resources/assets/frontend/js/jquery-ui.js',
        'resources/assets/frontend/js/bootstrap.bundle.min.js',

        'resources/assets/js/frontend.js'
    ], 'public/js/script.min.js')


    // ******************** Login ********************
    .styles([
        'resources/assets/frontend/css/bootstrap.min.css',
        'resources/assets/frontend/css/login_form.css',

        'public/assets/login.css'
    ], 'public/css/login.min.css')

    .scripts([
        'resources/assets/frontend/js/jquery.min.js',
        'resources/assets/frontend/js/jquery-3.5.1.min.js',
        'resources/assets/frontend/js/jquery-ui.js',
        'resources/assets/frontend/js/bootstrap.bundle.min.js',
        'resources/assets/frontend/js/login_form.js',

        'resources/assets/js/login.js'
    ], 'public/js/login.min.js')