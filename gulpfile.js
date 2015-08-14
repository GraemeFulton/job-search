
var gulp = require('gulp');

/**
 * Read in all the files under /gulp
 */
var fs = require('fs')
fs.readdirSync(__dirname + '/gulp').forEach(function(task){

	require('./gulp/' + task)
})

/**
 * Tasks
 */

gulp.task('watch:css', ['landingpage', 'mainstyles'], function(){

	gulp.watch('./wp-content/themes/buddy-boot/page-templates/landing-page-libs/css/*.scss', ['landingpage']);
	gulp.watch('./wp-content/themes/buddy-boot/*.scss', ['mainstyles']);

})
/**
 * Gulp dev task
 */
 gulp.task('dev', ['watch:css'])
