import {src, dest, watch, series} from 'gulp'
import * as dartSass from 'sass'
import gulpSass from 'gulp-sass'
import postcss from 'gulp-postcss'
import autoprefixer from 'autoprefixer'
import cssnano from 'cssnano'
import sourcemaps from 'gulp-sourcemaps'
import plumber from 'gulp-plumber'
import cache from 'gulp-cache'

const sass = gulpSass(dartSass);

const path = {
    scss: 'src/scss/**/*.scss',
    js: 'src/js/**/*.js',
    img: 'src/img/**/*.{jpg,png}',
    svg: 'src/img/**/*.svg'
}

export async function css( done ) {
    src(path.scss) // Identificar el archivo .SCSS a compilar
        .pipe(sourcemaps.init())
        .pipe( plumber())
        .pipe(sass().on('error', sass.logError))
        .pipe( postcss([ autoprefixer(), cssnano() ]) )
        .pipe(sourcemaps.write('.'))
        .pipe(  dest('public/build/css') );
    done();
}

export async function js( done ) {
    src(path.js)
        .pipe( dest('public/build/js') )
    done();
}


export async function dev() {
    watch(path.scss, css)
    watch(path.js, js)
}

export default series( css, js, dev )
