const gulp = require('gulp');

gulp.task('copy-files', function() {
  return gulp.src('src/**/*')
    .pipe(gulp.dest('dist'));
});

exports.copy = gulp.series('copy-files');
