'use strict';
/* =================== Configs ====================== */

var configs = {}
configs.build  = 'web/build/';
configs.source = 'src/AppBundle/Resources/public/site/';
configs.prod = false;
configs.icons = 'icons';

/* =================== Imports ====================== */

// Defaults
var gulp = require('gulp-param')(require('gulp'), process.argv);
var runSequence = require('run-sequence').use(gulp);
var del = require('del');
var rename = require('gulp-rename');
var gulpif = require('gulp-if');
var changed = require('gulp-changed');
var livereload = false;

/* ==================== Debug Tasks ======================= */

gulp.task('lint:styles', function() {
    var csslint = require('gulp-csslint');

    return gulp.src( configs.build + 'css/*.css' )
        .pipe(csslint())
        .pipe(csslint.reporter());
});

gulp.task('lint:scripts', function() {
    var jslint = require('gulp-jslint');

    return gulp.src( configs.build + 'js/*.js' )
        .pipe(jslint({ errorsOnly: true }));
});

/* ==================== Build Tasks ======================= */

gulp.task('styles', function () {
    // CSS
    var less = require('gulp-less');
    var postcss = require('gulp-postcss');
    var autoprefixer = require('autoprefixer-core');
    var a2cPrefixer = require('a2c-prefixer');
    var minifyCSS = require('gulp-minify-css');

    var styles = gulp.src( configs.source + 'css/**/style.less' )
        .pipe(less())
        .pipe(gulpif(configs.prod, postcss([ autoprefixer({  browsers: ['last 2 versions','IE > 6','Firefox < 20']  }), a2cPrefixer ])))
        .pipe(gulpif(configs.prod, minifyCSS({ compatibility : 'ie7' })))
        .pipe(rename({ suffix: '.min' }))
        .pipe(gulp.dest( configs.build + 'css'));

    if( configs.prod == false && livereload != false ) {
        styles.pipe(gulpif(!configs.prod, livereload()));
    }

    return styles;

});

gulp.task('scripts', function() {
    // JS
    var uglify = require('gulp-uglify');
    var concat = require('gulp-concat');

    gulp.src(configs.source + 'js/vendor/**/*.js')
        .pipe(gulpif(!configs.prod, changed(configs.build + 'js/vendor/')))
        .pipe(gulp.dest(configs.build + 'js/vendor/'));

    gulp.src(configs.source + 'js/plugins/*.js')
        .pipe(concat('plugins.js'))
        .pipe(gulpif(configs.prod, uglify()))
        .pipe(rename({  suffix: '.min' }))
        .pipe(gulp.dest(configs.build + 'js'));

    return gulp.src(configs.source + 'js/*.js')
        .pipe(concat('main.js'))
        .pipe(gulpif(configs.prod, uglify()))
        .pipe(rename({  suffix: '.min' }))
        .pipe(gulp.dest(configs.build + 'js'));
});

gulp.task('images', function () {
    //Images
    var imagemin = require('gulp-imagemin');
    var pngquant = require('imagemin-pngquant');
    var imageminJpegtran = require('imagemin-jpegtran');

    return gulp.src(configs.source + 'img/**/*')
        .pipe(gulpif(!configs.prod, changed(configs.build + 'img')))
        .pipe(gulpif(configs.prod, imagemin({  optimizationLevel: 7, progressive: true, use: [pngquant(), imageminJpegtran({progressive: true})] })))
        .pipe(gulp.dest(configs.build + 'img'));
});

gulp.task('icons', function(){
    // Icons
    var iconfont = require('gulp-iconfont');
    var iconfontCss = require('gulp-iconfont-css');

    return gulp.src([configs.source + 'icon/**/*.svg'], {base: './web'})
        .pipe(iconfontCss({
            fontName: configs.icons,
            path: configs.source + 'icon/_template.less',
            targetPath: '../../../' + configs.source + '/css/_icons.less',
            fontPath: '../font/'
        }))
        .pipe(iconfont({
            fontName: configs.icons,
            normalize: true
        }))
        .pipe(gulp.dest(configs.build + 'font/'));
});

// Bug PNG Entrelaçado
gulp.task('sprites', function () {
    // Sprite
    var spritesmith = require('gulp.spritesmith');

    return gulp.src(configs.source + 'sprite/**/*.png')
        .pipe(spritesmith({
            imgName: 'img/sprite.png',
            cssName: 'css/_sprite.less',
            cssTemplate: configs.source + 'sprite/template.handlebars'
        }))
        .pipe(gulp.dest( configs.source ));
});

/* ================ Project Tasks =================== */

gulp.task('listen', function(){
    configs.prod = false;
    var watch = require('gulp-watch');
    livereload = require('gulp-livereload');

    livereload.listen();
    gulp.watch(configs.source + 'css/**/*.less',['styles']);
    gulp.watch(configs.source + 'icon/**/*.svg', ['icons']);
    gulp.watch(configs.source + 'js/**/*.js',['scripts']);
    gulp.watch(configs.source + 'img/**/*',['images']);
    gulp.watch(configs.source + 'sprite/**/*', ['sprites']);
});

gulp.task('clean', function (cb) {
    del([ configs.build  ], cb);
});

gulp.task('build', function(production){

    configs.prod = ( production == true )? true : false;
    return runSequence('sprites','icons','styles','scripts','images');
});
