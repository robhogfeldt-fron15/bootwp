var gulp          = require('gulp');
var sass          = require('gulp-sass');
var concat        = require('gulp-concat');
var jshint        = require('gulp-jshint');
var uglify        = require('gulp-uglify');
var browserSync   = require('browser-sync');
var reload        = browserSync.reload;
var autoprefixer = require('gulp-autoprefixer');
gulp.task('browser-sync', function() {
    //watch files
    var files = [
    './style.css',
    './*.php'
    ];


    browserSync.init(files, {
    proxy: "localhost/localwp.com/",
    notify: true
    });
});

//Output Sass-folder to style.css
gulp.task('sass', function () {
    gulp.src('./sass/*.scss')
        .pipe(sass())
        .pipe(autoprefixer())
        .pipe(concat('style.css'))
        .pipe(gulp.dest('./'));
});


//Output and concat ThemeJs to scripts.js
gulp.task('customJs', function () {
  gulp.src('js/*.js')
      .pipe(jshint())
      .pipe(jshint.reporter('fail'))
      .pipe(concat('scripts.js'))
      .pipe(gulp.dest('js'));
});





// Default task to be run with `gulp`
gulp.task('default', ['sass', 'browser-sync'], function () {
    gulp.watch("sass/**/*.scss",  ['sass']);
});
