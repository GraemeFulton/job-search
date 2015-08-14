var gulp = require('gulp')
var sass = require('gulp-sass');

gulp.task('landingpage', function(){

	gulp.src('./wp-content/themes/buddy-boot/page-templates/landing-page-libs/css/*.scss')
	.pipe(sass().on('error', sass.logError))
	.pipe(gulp.dest('wp-content/themes/buddy-boot/page-templates/landing-page-libs/css'))
})

gulp.task('mainstyles', function(){

	gulp.src('./wp-content/themes/buddy-boot/*.scss')
	.pipe(sass().on('error', sass.logError))
	.pipe(gulp.dest('./wp-content/themes/buddy-boot'))
})
