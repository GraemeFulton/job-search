var gulp = require('gulp')
var sass = require('gulp-sass');
var livereload = require('gulp-livereload');


gulp.task('landingpage', function(){

	gulp.src('./wp-content/themes/buddy-boot/css/*.scss')
	.pipe(sass().on('error', sass.logError))
	.pipe(gulp.dest('wp-content/themes/buddy-boot/css'))
  .pipe(livereload());
})

gulp.task('mainstyles', function(){

	gulp.src('./wp-content/themes/buddy-boot/*.scss')
	.pipe(sass().on('error', sass.logError))
	.pipe(gulp.dest('./wp-content/themes/buddy-boot'))
  .pipe(livereload());
})
