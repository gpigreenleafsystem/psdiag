// webpack.mix.js

const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .js('resources/js/calendar.js', 'public/js') // Add this line
   .postCss('resources/css/app.css', 'public/css', [
       //
   ]);

