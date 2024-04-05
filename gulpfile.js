const gulp = require('gulp');
const sass = require('gulp-sass');
const autoprefixer = require('gulp-autoprefixer');
const cleanCSS = require('gulp-clean-css');
const uglify = require('gulp-uglify');
const rename = require('gulp-rename');
const concat = require('gulp-concat');
const uglify = require('gulp-uglify');

gulp.task('styles', function() {
  return gulp.src('src/css/*.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(autoprefixer())
    .pipe(cleanCSS())
    .pipe(rename({ suffix: '.min' }))
    .pipe(gulp.dest('dist/css'));
});

gulp.task('scripts', function() {
  return gulp.src('src/js/*.js')
    .pipe(uglify())
    .pipe(rename({ suffix: '.min' }))
    .pipe(gulp.dest('dist/js'));
});

gulp.task('default', gulp.parallel('styles', 'scripts'));

const concat = require('gulp-concat');
const uglify = require('gulp-uglify');

gulp.task('js', function() {
    return gulp.src('src/js/*.js') 
        .pipe(concat('bundle.js')) 
        .pipe(uglify())
        .pipe(gulp.dest('dist/js')); 
});

gulp.task('default', gulp.series('js'));
