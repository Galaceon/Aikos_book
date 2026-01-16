const { src, dest, watch, parallel } = require('gulp');

// CSS
const sass = require('gulp-sass')(require('sass'));
const sourcemaps = require('gulp-sourcemaps');
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');
const cssnano = require('cssnano');

// JS
const terser = require('gulp-terser-js');
const concat = require('gulp-concat');

// Imágenes
const imagemin = require('gulp-imagemin');
const webp = require('gulp-webp');
const avif = require('gulp-avif');

const paths = {
  scss: 'src/scss/**/*.scss',
  js: 'src/js/**/*.js',
  img: 'src/img/**/*'
};

// CSS
function css() {
  return src(paths.scss)
    .pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    .pipe(postcss([autoprefixer(), cssnano()]))
    .pipe(sourcemaps.write('.'))
    .pipe(dest('build/css'));
}

// JS
function js() {
  return src(paths.js)
    .pipe(sourcemaps.init())
    .pipe(concat('app.min.js'))
    .pipe(terser())
    .pipe(sourcemaps.write('.'))
    .pipe(dest('build/js'));
}

// Imágenes
function images() {
  return src(paths.img)
    .pipe(imagemin())
    .pipe(dest('build/img'));
}

function imagesWebp() {
  return src('src/img/**/*.{jpg,png}')
    .pipe(webp({ quality: 80 }))
    .pipe(dest('build/img'));
}

function imagesAvif() {
  return src('src/img/**/*.{jpg,png}')
    .pipe(avif({ quality: 50 }))
    .pipe(dest('build/img'));
}

function dev() {
  watch(paths.scss, css);
  watch(paths.js, js);
  watch(paths.img, parallel(images, imagesWebp, imagesAvif));
}

exports.dev = parallel(css, js, images, imagesWebp, imagesAvif, dev);
