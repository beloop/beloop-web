const del = require('del');
const gulp = require('gulp');
const cleanCSS = require('gulp-clean-css');
const less = require('gulp-less');
const rename = require("gulp-rename");
const uglify = require('gulp-uglify');

gulp.task('clean', function clean() {
    return del([
        'web/css/**/*',
        'web/fonts/**/*',
        'web/js/**/*'
    ]);
});

gulp.task('copy-assets', function copyAssets() {
    return gulp.src([
            './web/less/fonts/**/*.*'
        ])
        .pipe(gulp.dest('./web/fonts'));
});

gulp.task('javascript', function javascript() {
    return gulp.src([
            './web/src/*.*'
        ])
        .pipe(uglify())
        .pipe(rename('main.min.js'))
        .pipe(gulp.dest('./web/js'));
});

gulp.task('build-css', function less() {
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

gulp.task('build', gulp.series('clean', gulp.series('copy-assets', 'build-css', 'javascript')));
