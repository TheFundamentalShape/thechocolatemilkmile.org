const mix = require('laravel-mix');
const tailwind = require('tailwindcss');

require('dotenv').config();

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

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .js('resources/js/nav.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .options({
        processCssUrls: false,
        postCss: [
            tailwind('./tailwind.config.js'),
            require('autoprefixer')
        ]
    });

mix.browserSync({
    proxy: 'https://cmm-new.test',
    https: true,
});