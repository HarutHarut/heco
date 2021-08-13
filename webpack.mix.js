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
mix
    .js('resources/js/app.js', 'public/js')
    .vue()
    .js('resources/js/app-front.js', 'public/js')
    .js('resources/js/dashboard-app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/app-front.scss', 'public/css')
    .sass('resources/sass/home.scss', 'public/css')
    .sass('resources/sass/main.scss', 'public/css')
    .sass('resources/sass/shop.scss', 'public/css')
    .sass('resources/sass/blog.scss', 'public/css')
    .sass('resources/sass/shop-single.scss', 'public/css')
    .sass('resources/sass/compare.scss', 'public/css')
    .sass('resources/sass/cart.scss', 'public/css')
    .sass('resources/sass/sell.scss', 'public/css')
    .sass('resources/sass/profile.scss', 'public/css')
    .sass('resources/sass/dashboard-app.scss', 'public/css')
    .version();

