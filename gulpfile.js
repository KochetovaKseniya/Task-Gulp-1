const gulp = require('gulp');

// Задача для копирования файлов
gulp.task('copy-files', function() {
  return gulp.src('src/**/*')
    .pipe(gulp.dest('dist'));
});

// Экспорт задачи для использования из командной строки
exports.copy = gulp.series('copy-files');
