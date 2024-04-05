const gulp = require("gulp");
const sass = require("gulp-sass")(require("sass"));
const cleanCSS = require("gulp-clean-css");
const autoprefixer = require("gulp-autoprefixer");
const rename = require("gulp-rename");

const uglify = require('gulp-uglify');


gulp.task("styles", function () {
    return gulp
      .src("src/scss/**/*.+(scss|sass)")
      .pipe(sass({ outputStyle: "compressed" }).on("error", sass.logError))
      .pipe(rename({ suffix: ".min", prefix: "" }))
      .pipe(autoprefixer())
      .pipe(cleanCSS({ compatibility: "ie8" }))
      .pipe(gulp.dest("assets-green-2023/min-css"));
});

gulp.task('scripts', function() {
    return gulp
      .src(['src/js/*.js'])
      .pipe(rename({ suffix: ".min", prefix: "" }))
      .pipe(uglify())
      .pipe(gulp.dest('assets-green-2023/min-js'));
});

gulp.task("watch", function () {
  gulp.watch("src/scss/**/*.+(scss|sass|css)", gulp.parallel("styles"));
  gulp.watch('src/js/*.js', gulp.series("scripts"));
});

gulp.task("default", gulp.parallel("styles", "scripts", "watch"));