const { gulp, src, dest, watch, series } = require('gulp');
const concat = require('gulp-concat');
const browserSync = require('browser-sync').create();

const clean = require('gulp-clean');
const order = require('gulp-order');
const uglify = require('gulp-uglify');
const rename = require('gulp-rename');

/********************************************************************************************************************/
/*                                                                                                                  */
/* Directories                                                                                                      */
/*                                                                                                                  */
/********************************************************************************************************************/
const assetsDir = 'assets/';
const jsDir = assetsDir + 'js/';

/********************************************************************************************************************/
/*                                                                                                                  */
/* Clean JS directory                                                                                               */
/*                                                                                                                  */
/********************************************************************************************************************/

function cleanJs() {
    return src(assetsDir + 'main.min.js', {read: false, allowEmpty: true})
        .pipe(clean({force: true}));
}

function compileJs() {
    return src(jsDir + '**/*.js')
        .pipe(order())
        .pipe(concat('main.min.js'))
        .pipe(uglify())
        .pipe(dest(assetsDir))
        .pipe(browserSync.stream());
}

function watchTask() {
    watch([jsDir + '**/*.js'], compileJs)
}

exports.build = series(cleanJs, compileJs, watchTask);