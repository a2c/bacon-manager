// ------ Configuração Parametros e plugins ------------- //
var dirAssetsJs     = './web/assets/js';
var dirAssetsFonts  = './web/assets/fonts';
var dirAssetsCss    = './web/assets/css';

var gulp        = require('gulp');
var uglify      = require('gulp-uglify');
var concat      = require('gulp-concat');
var cssMin      = require('gulp-css');
var concatCss   = require('gulp-concat-css');
// ------ FIM Configuração Parametros e plugins  ------------- //

// ------ Configuração JS ------------- //
var jsVendor = [
    './web/vendor/jquery/dist/jquery.js',
    './web/vendor/jquery-validation/dist/jquery.validate.js',
    './web/vendor/jquery-validation/src/localization/messages_pt_BR.js',
    './web/vendor/jquery-validation/dist/additional-methods.js',
    './web/vendor/admin-lte/bootstrap/js/bootstrap.min.js',
    './web/vendor/admin-lte/plugins/datepicker/bootstrap-datepicker.js',
    './web/vendor/admin-lte/plugins/slimScroll/jquery.slimscroll.min.js',
    './web/vendor/admin-lte/plugins/iCheck/icheck.min.js',
    './web/vendor/admin-lte/plugins/select2/select2.full.js',
    './web/vendor/admin-lte/dist/js/app.min.js'
];

var jsBundles = [
    './vendor/baconmanager/core-bundle/Resources/public/js/main.js'
];
// ------ FIM Configuração JS ------------- //

// ------ Configuração Fonts ------------- //
var fontsFiles = [
    './web/vendor/admin-lte/bootstrap/fonts/glyphicons-halflings-regular.*'
];
// ------ FIM Configuração Fonts --------- //

// ------ Configuração Images ------------- //
var imagesFilesToCss = [
    './web/vendor/admin-lte/plugins/iCheck/square/blue.png',
    './web/vendor/admin-lte/plugins/iCheck/square/blue@2x.png',
];
// ------ FIM Configuração Fonts --------- //


// ------ Configuração CSS ------------- //
var cssVendorFiles = [
    './web/vendor/admin-lte/bootstrap/css/bootstrap.min.css',
    './web/vendor/admin-lte/plugins/datepicker/datepicker3.css',
    './web/vendor/admin-lte/plugins/colorpicker/bootstrap-colorpicker.min.css',
    './web/vendor/admin-lte/plugins/select2/select2.min.css',
    './web/vendor/admin-lte/plugins/iCheck/minimal/_all.css',
    './web/vendor/admin-lte/plugins/iCheck/square/_all.css',
    './web/vendor/admin-lte/plugins/iCheck/flat/_all.css',
    './web/vendor/admin-lte/plugins/iCheck/line/_all.css',
    './web/vendor/admin-lte/plugins/iCheck/polaris/polaris.css',
    './web/vendor/admin-lte/plugins/iCheck/futurico/futurico.css',
    './web/vendor/admin-lte/plugins/iCheck/square/blue.css',
    './web/vendor/admin-lte/dist/css/AdminLTE.min.css',
    './web/vendor/admin-lte/dist/css/skins/_all-skins.min.css'
];

var cssBundlesFiles = [
    './vendor/baconmanager/core-bundle/Resources/public/css/admin/style.css'
];
// ------ FIM Configuração CSS --------- //

// ------ Tasks de JS --------------------- //
gulp.task('minify-vendor-js', function() {
    gulp
        .src(jsVendor)
        .pipe(concat('vendor.js'))
        .pipe(uglify())
        .pipe(gulp.dest(dirAssetsJs))
    ;
});

gulp.task('minify-bundles-js', function() {
    gulp
        .src(jsBundles)
        .pipe(concat('bundles.js'))
        .pipe(uglify())
        .pipe(gulp.dest(dirAssetsJs))
    ;
});
// ------ FIM Tasks de JS ---------------- //
imagesFilesToCss
// ------ Tasks copia de Fonts ----------- //
gulp.task('fonts', function () {
    gulp
        .src(fontsFiles)
        .pipe(gulp.dest(dirAssetsFonts))
    ;
});
// ------ FIM Tasks copia de Fonts ------- //

// ------ Tasks copia de Fonts ----------- //
gulp.task('images-css', function () {
    gulp
        .src(imagesFilesToCss)
        .pipe(gulp.dest(dirAssetsCss))
    ;
});
// ------ FIM Tasks copia de Fonts ------- //

// ------ Tasks CSS ----------- //
gulp.task('concat-vendor-css', function () {
    return gulp
        .src(cssVendorFiles)
        .pipe(concat('vendor.css'))
        .pipe(cssMin())
        .pipe(gulp.dest(dirAssetsCss))
        ;
});

gulp.task('concat-bundles-css', function () {
    return gulp
        .src(cssBundlesFiles)
        .pipe(concat('bundles.css'))
        .pipe(cssMin())
        .pipe(gulp.dest(dirAssetsCss))
        ;
});
// ------ FIM Tasks CSS ------- //

gulp.task('default', ['minify-vendor-js','minify-bundles-js','fonts','concat-bundles-css','concat-vendor-css','images-css']);
