'use strict'

const template = './wp-content/themes/wp-ajax-smart-form'

const gulp = require('gulp')
const sass = require('gulp-sass')(require('sass'))
const concat = require('gulp-concat')
const autoprefixer = require('gulp-autoprefixer')
const cssnano = require('gulp-cssnano')
const rename = require('gulp-rename')

function compileCss() {
  return gulp
    .src(`${template}/scss/main.scss`)
    .pipe(sass().on('error', sass.logError))
    .pipe(autoprefixer('last 2 versions'))
    .pipe(cssnano())
    .pipe(concat('main.css'))
    .pipe(rename({ suffix: '.min' }))
    .pipe(gulp.dest(`${template}/dist`))
}

function watchFiles() {
  gulp.watch(`${template}/scss/**/*.scss`, compileCss)
}

const build = gulp.series(compileCss, watchFiles)

// Export tasks.
exports.compileCss = compileCss

exports.watch = watchFiles
exports.build = build
exports.default = build
