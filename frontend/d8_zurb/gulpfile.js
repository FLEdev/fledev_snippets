var $            = require('gulp-load-plugins')();
var sourceDir    = 'src';
var project      = 'trade';
var destDir7      = '../htdocs/sites/all/themes/' + project + '/engine';
var destDir      = '../htdocs/themes/' + project + '/engine';
var argv         = require('yargs').argv;
var isProduction = !!(argv.production);
var gulp         = require("gulp");
var browser      = require('browser-sync');
var rimraf       = require('rimraf');
var sequence     = require('run-sequence');
var path         = require('path');

//Require any other plugins
var concat       = require("gulp-concat");
var sass         = require("gulp-sass");
var rename       = require("gulp-rename");
var autoprefixer = require("gulp-autoprefixer");
var flatten      = require("gulp-flatten");

var paths = {
    assets: [
        'assets/**/*',
        '!assets/{!img,js,scss}/**/*'
    ],
    sass: [
        'bower_components/owlcarousel/owl-carousel',
        'bower_components/foundation-sites/scss',
        'bower_components/motion-ui/src/'
    ],
    javascript: [
        //'bower_components/colorbox/jquery.colorbox.js',
        //'bower_components/jquery/dist/jquery.js',
        'bower_components/what-input/what-input.js',
        'bower_components/foundation-sites/dist/foundation.js',
        'bower_components/foundation-sites/dist/plugins/foundation.abide.js',
        'bower_components/foundation-sites/dist/plugins/foundation.accordion.js',
        'bower_components/foundation-sites/dist/plugins/foundation.accordionMenu.js',
        'bower_components/foundation-sites/dist/plugins/foundation.core.js',
        'bower_components/foundation-sites/dist/plugins/foundation.drilldown.js',
        'bower_components/foundation-sites/dist/plugins/foundation.dropdown.js',
        'bower_components/foundation-sites/dist/plugins/foundation.dropdownMenu.js',
        'bower_components/foundation-sites/dist/plugins/foundation.equalizer.js',
        'bower_components/foundation-sites/dist/plugins/foundation.interchange.js',
        'bower_components/foundation-sites/dist/plugins/foundation.magellan.js',
        'bower_components/foundation-sites/dist/plugins/foundation.offcanvas.js',
        'bower_components/foundation-sites/dist/plugins/foundation.orbit.js',
        'bower_components/foundation-sites/dist/plugins/foundation.responsiveMenu.js',
        'bower_components/foundation-sites/dist/plugins/foundation.responsiveToggle.js',
        'bower_components/foundation-sites/dist/plugins/foundation.reveal.js',
        'bower_components/foundation-sites/dist/plugins/foundation.slider.js',
        'bower_components/foundation-sites/dist/plugins/foundation.sticky.js',
        'bower_components/foundation-sites/dist/plugins/foundation.tabs.js',
        'bower_components/foundation-sites/dist/plugins/foundation.toggler.js',
        'bower_components/foundation-sites/dist/plugins/foundation.tooltip.js',
        'bower_components/foundation-sites/dist/plugins/foundation.util.box.js',
        'bower_components/foundation-sites/dist/plugins/foundation.util.keyboard.js',
        'bower_components/foundation-sites/dist/plugins/foundation.util.mediaQuery.js',
        'bower_components/foundation-sites/dist/plugins/foundation.util.motion.js',
        'bower_components/foundation-sites/dist/plugins/foundation.util.nest.js',
        'bower_components/foundation-sites/dist/plugins/foundation.util.timerAndImageLoader.js',
        'bower_components/foundation-sites/dist/plugins/foundation.util.touch.js',
        'bower_components/foundation-sites/dist/plugins/foundation.util.triggers.js',
        'src/js/drupal.js',
        'src/js/foundation.js'
    ]
};


function dest(_segments) {
    return path.join.apply(path, [destDir].concat(Array.prototype.slice.call(arguments)));
}

function source(_segments) {
    return path.join.apply(path, [sourceDir].concat(Array.prototype.slice.call(arguments)));
}

gulp.task('build', function(done) {
    sequence('clean', ['sass', 'javascript', 'copy'], done);
});

gulp.task('develop', ['build'], function() {
    gulp.watch([source('assets/**/*')], ['clean', 'copy']);
    gulp.watch([source('scss/**/*')], ['sass'])
    gulp.watch([source('js/**/*')], ['javascript'])
});

gulp.task('copy', function() {
    return gulp.src(source('assets/**/*')).pipe(gulp.dest(dest('assets')));
});

gulp.task('clean', function(done) {
    rimraf(dest(), done);
});

gulp.task('sass', function() {
    return gulp.src(source('scss/index.scss'))
        .pipe($.sourcemaps.init())
        .pipe($.concat('style.min.js'))
        .pipe($.sass({
            includePaths: paths.sass
        })
        .on('error', $.sass.logError))
        .pipe($.autoprefixer({
            browsers: ['last 2 versions', 'ie >= 9']
        }))
        .pipe($.if(isProduction, $.minifyCss()))
        .pipe($.if(!isProduction, $.sourcemaps.write()))
        /*.pipe($.minifyCss())
        .pipe($.sourcemaps.write()) */
        .pipe(gulp.dest(dest('css')));
});

gulp.task('javascript', function() {
    return gulp.src(paths.javascript)
        .pipe($.sourcemaps.init())
        .pipe($.concat('script.min.js'))
        .pipe($.if(isProduction, $.uglify().on('error', function (e) {console.log(e);})))
        .pipe($.if(!isProduction, $.sourcemaps.write()))
        /*.pipe($.uglify().on('error', function (e) {console.log(e);}))
        .pipe($.sourcemaps.write())*/
        .pipe(gulp.dest(dest('js')));
});

gulp.task('default', ['build']);

/*
gulp.task("sass", function(){
    return gulp.src(["src/scss/app.scss", "src/scss/variables.scss", "src/scss/utilities.scss", "src/scss/*.scss", "!src/scss/*.concat.scss"])
        .pipe(concat("styles.concat.scss"))
        .pipe(gulp.dest("src/scss"))
        .pipe(sass({includePaths: ["bower_components/foundation-sites/scss", "bower_components/motion_ui/src"]}))
        .pipe(rename("styles.css"))
        .pipe(gulp.dest("src/css"))
        .pipe(autoprefixer({
            browsers: ["last 2 versions"],
            cascade: false
        }))
        .pipe(gulp.dest("src/css"));
});

//Gulp watch task
//gulp.watch("files-to-watch", ["task(s)", "to", "run"]);
gulp.task("watch", function(){
    gulp.watch("src/scss/*.scss", ["sass"]);
    //Other tasks
});

//Default task (ie. $ gulp)
gulp.task("default", ["sass"]);
*/