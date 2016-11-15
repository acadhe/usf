// var gulp = require('gulp'),
// 	autoprefixer = require('gulp-autoprefixer'),
var	elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */
// elixir.extend('autoprefix', function() {
//      gulp.task('style', function() {
//         .pipe(autoprefixer())
//     });
// });
elixir.config.sourcemaps = false;
elixir(function(mix) {
	// mix.sass('responsive.scss', 'public/frontend/css/responsive.css');
	mix.sass('large-below-desktop.scss', 'public/frontend/css/large-below-desktop.css');
	mix.sass('medium.scss', 'public/frontend/css/medium.css');
	mix.sass('small.scss', 'public/frontend/css/small.css');
	mix.sass('styles.scss', 'public/frontend/css/styles.css');
	// mix.browserSync([
	// 	'app/**/*',
	// 	'public/**/*',
	// 	'resources/views/**/*'
	// ]);
	mix.browserSync({
        proxy: 'localhost:8000'
    });
	mix.version('frontend/css/styles.css');
});

//php artisan serve --host=0 dulu sebelum masuk gulp watch