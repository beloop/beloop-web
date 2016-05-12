var del = require('del');
var gulp = require('gulp');
var cleanCSS = require('gulp-clean-css');
var less = require('gulp-less');
var rename = require("gulp-rename");
var runSequence = require('run-sequence');
var uglify = require('gulp-uglify');

gulp.task('clean', function () {
    return del([
        'web/css/**/*',
        'web/fonts/**/*',
        'web/js/**/*'
    ]);
});

gulp.task('copy-assets', function () {
    return gulp.src([
            './web/less/fonts/**/*.*'
        ])
        .pipe(gulp.dest('./web/fonts'));
});

gulp.task('javascript', function () {
    return gulp.src([
            './web/src/*.*'
        ])
        .pipe(uglify())
        .pipe(rename('main.min.js'))
        .pipe(gulp.dest('./web/js'));
});

gulp.task('less', function () {
    gulp.src('./web/less/login.less')
        .pipe(less())
        .pipe(cleanCSS())
        .pipe(rename('login.min.css'))
        .pipe(gulp.dest('./web/css'));

    return gulp.src('./web/less/style.less')
        .pipe(less())
        .pipe(cleanCSS())
        .pipe(rename('style.min.css'))
        .pipe(gulp.dest('./web/css'));
});

gulp.task('build', ['clean'], function (callback) {
    runSequence(
        ['copy-assets', 'less', 'javascript'],
        callback
    );
});