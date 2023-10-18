const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const cleanCSS = require('gulp-clean-css');
const rename = require('gulp-rename');

// Compile SCSS to CSS, minify, and save to assets/css
gulp.task('build-css', function () {
	return gulp.src('src/scss/index.scss')
	           .pipe(sass())
	           .pipe(cleanCSS())
	           .pipe(rename('style.css'))
	           .pipe(gulp.dest('assets/css'));
});

// Compile JS
gulp.task('build-js', function () {
	return gulp.src('src/js/index.js')
	           .pipe(rename('script.js'))
	           .pipe(gulp.dest('assets/js'));
})

// Compile both
gulp.task('build', gulp.series('build-css', 'build-js'));

// Watch for changes in SCSS files
gulp.task('watch', function () {
	gulp.watch('src/scss/*.scss', gulp.series('build-css'));
});

// Default task: watch for changes
gulp.task('default', gulp.series('build-css', 'watch'));
