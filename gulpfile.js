var gulp = require('gulp')
  , sass = require('gulp-sass')

const SOURCES = './assets/styles/*.scss'
  , DEST = './assets/styles/'

gulp.task('default', ['sass', 'watch'])

gulp.task('sass', function() {
  gulp.src(SOURCES)
    .pipe(sass())
    .pipe(gulp.dest(DEST))
})

gulp.task('watch', function () {
	gulp.watch(SOURCES, ['sass'])
})
