var del = require('del');
var gulp = require('gulp');
var cleanCSS = require('gulp-clean-css');
var less = require('gulp-less');
var rename = require("gulp-rename");
var runSequence = require('run-sequence');

gulp.task('clean', function () {
    return del([
        'web/css/**/*',
        'web/fonts/**/*',
        'web/js/**/*',
    ]);
});

gulp.task('copy-assets', function () {
    return gulp.src([
            './web/less/fonts/**/*.*'
        ])
        .pipe(gulp.dest('./web/fonts'));
});

gulp.task('less', function () {
    return gulp.src('./web/less/login.less')
        .pipe(less())
        .pipe(cleanCSS())
        .pipe(rename('login.min.css'))
        .pipe(gulp.dest('./web/css'));

    // return gulp.src('./web/less/style.less')
    //     .pipe(less())
    //     .pipe(cleanCSS())
    //     .pipe(rename('style.min.css'))
    //     .pipe(gulp.dest('./web/css'));
});

gulp.task('build', ['clean'], function (callback) {
    runSequence(
        'copy-assets',
        'less',
        callback
    );
});