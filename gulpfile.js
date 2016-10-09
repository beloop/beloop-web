const gulp = require('gulp');
const webpack = require('webpack-stream');
const $ = require('gulp-load-plugins')({
    pattern: [ 'gulp-*', 'del', 'run-sequence' ]
});

const webpackOptions = require('./webpack.config.js');

const packScripts = function(watch, callback) {
    webpackOptions.watch = watch;
    const webpackChangeHandler = function(err, stats) {
        if (err) {
            console.error(err);
        }

        $.util.log(stats.toString({
            colors: $.util.colors.supportsColor,
            chunks: false,
            hash: false,
            version: false
        }));

        if (watch) {
            watch = false;
            callback();
        }
    };

    return gulp.src([
        './web/admin/admin.js',
        './web/admin/vendor.js'
    ])
    .pipe(webpack(webpackOptions, null, webpackChangeHandler))
    .pipe($.ngAnnotate())
    .pipe($.uglify())
    .pipe($.rename({
        suffix: ".min"
    }))
    .pipe(gulp.dest('./web/js'));
};

gulp.task('clean', function () {
    return $.del([
        'web/js/admin*'
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
    .pipe($.uglify())
    .pipe($.rename('main.min.js'))
    .pipe(gulp.dest('./web/js'));
});

gulp.task('angular', () => packScripts(false));
gulp.task('angular:watch', (callback) => packScripts(true, callback));

gulp.task('less', function () {
    gulp.src('./web/less/login.less')
        .pipe($.less())
        .pipe($.cleanCss())
        .pipe($.rename('login.min.css'))
        .pipe(gulp.dest('./web/css'));

    return gulp.src('./web/less/style.less')
        .pipe($.less())
        .pipe($.cleanCss())
        .pipe($.rename('style.min.css'))
        .pipe(gulp.dest('./web/css'));
});

gulp.task('build', ['clean'], function (callback) {
    $.runSequence(
        ['copy-assets', 'less', 'javascript', 'angular'],
        callback
    );
});