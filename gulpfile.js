var gulp = require('gulp')
  , sass = require('gulp-sass')
  , autoprefixer = require('gulp-autoprefixer')

const SOURCES = './assets/styles/*.scss'
  , DEST = './assets/styles/'

gulp.task('default', ['sass', 'watch'])

gulp.task('sass', function() {
  gulp.src(SOURCES)
    .pipe(sass())
    .pipe(autoprefixer({
      browsers: ['last 2 versions']
      , cascade: false
      , remove: true // Remove cruft
    }))
    .pipe(gulp.dest(DEST))
})

gulp.task('watch', function () {
	gulp.watch(SOURCES, ['sass'])
})
