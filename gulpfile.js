/**
 * Require packages
 * 
 * TODO: make sure everything from package is used
 */
var gulp = require('gulp'),
  autoprefixer = require('gulp-autoprefixer'),
  babelify = require('babelify'),
  browserify = require('browserify'),
  buffer = require('vinyl-buffer'),
  cheerio = require('gulp-cheerio'),
  eslint = require('gulp-eslint'),
  imagemin = require('gulp-imagemin'),
  sass = require('gulp-sass'),
  source = require('vinyl-source-stream'),
  svgstore = require('gulp-svgstore'),
  uglify = require('gulp-uglify'),
  watchify = require('watchify');

var livereload = require('gulp-livereload'),
  lr = require('tiny-lr'),
  server = lr();

/**
 * Directory Config
 */
var dirConfig = {
  images: {
    src: './src/images/',
    dist: './public/images/',
  },
  scripts: {
    entries: './src/scripts/**/*.js',
    src: './src/scripts/index.js',
    dist: './public/scripts/',
    test: './tests/**/*.test.js',
  },
  styles: {
    entries: './src/styles/**/*.scss',
    src: './src/styles/index.scss',
    dist: './public/styles/',
  }
};

/**
 * IMAGES
 *
 * optimizationLevel set to 0 to disable CPU-intensive image crunching.
 * Use ImageOptim (lossless) on your source images.
 * We do want images to be progressive and interlaced, though.
 */
gulp.task('images', function() {
  return gulp.src([
      dirConfig.images.src + '**/*.gif',
      dirConfig.images.src + '**/*.jpg',
      dirConfig.images.src + '**/*.png',
    ])
    .pipe(imagemin({
      optimizationLevel: 0,
      progressive: true,
      interlaced: true,
    }))
    .pipe(gulp.dest(dirConfig.images.dist));
});

/**
 * IMAGES:SVGSPRITE
 *
 * Combine all svgs in target directory into a single spritemap.
 */
gulp.task('images:svgsprite', function() {
  return gulp.src([
      dirConfig.images.src + 'sprites/*.svg'
    ])
    .pipe(svgstore({ inlineSvg: true }))
    .pipe(cheerio({
      run: function($) {
        $('svg').attr('style', 'display:none'); // make sure the spritemap doesn't show
      },
      parserOptions: { lowerCaseAttributeNames: false },
    }))
    .on('error', function(err) { displayError(err); })
    .pipe(gulp.dest(dirConfig.images.dist + 'sprites/'));
});

/**
 * STYLES
 *
 * Compile and compress SASS
 * Autoprefixer's 'browser' option is supplied by .browserslistrc
 */
gulp.task('styles', function() {
  gulp.src([
      dirConfig.styles.entries
    ])
    .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
    .pipe(autoprefixer())
    .pipe(gulp.dest(dirConfig.styles.dist))
    .pipe(livereload(server));
});

/**
 * STYLES:WATCH
 *
 * Watch SASS for changes
 */
gulp.task('styles:watch', function() {
  return gulp.watch(dirConfig.styles.src, ['styles:sass']);
});

/**
 * SCRIPTS:LINT
 *
 * Lint scripts using .eslintrc
 */
function lintJs() {
  return gulp.src([
      dirConfig.scripts.src,
      dirConfig.scripts.test
    ])
    .pipe(eslint())
    .pipe(eslint.format());
}
gulp.task('scripts:lint', lintJs);

/**
 * SCRIPTS
 *
 * Transpile and bundle JS
 */
gulp.task('scripts', function() {
  var bundler = browserify(dirConfig.scripts.src).transform(babelify);

  return bundler.bundle()
    .on('error', function(err) {
      console.error(err);
      this.emit('end');
    })
    .pipe(source('index.js'))
    .pipe(buffer())
    .pipe(uglify())
    .pipe(gulp.dest(dirConfig.scripts.dist));
});

/**
 * SCRIPTS:WATCH
 *
 * Watch JS for changes
 */
gulp.task('scripts:watchify', function() {
  watchify.args.debug = true;
  var bundler = watchify(browserify(dirConfig.scripts.src, watchify.args).transform(babelify));

  bundler.on('update', rebundle);

  function rebundle() {
    lintJs();

    return bundler.bundle()
      .on('error', function(err) {
        console.error(err);
        this.emit('end');
      })
      .pipe(source('index.js'))
      .pipe(gulp.dest(dirConfig.scripts.dist))
      .pipe(livereload(server));
  }

  return rebundle();
});

/**
 * WATCH
 *
 * Watch for changes in styles and scripts
 */
gulp.task('watch', ['styles:watch', 'scripts:watchify'], function() {
  livereload.listen(server);
});

/**
 * BUILD
 *
 * Wrapper for bundled build task
 */
gulp.task('build', ['images', 'scripts', 'styles']);

/**
 * DEFAULT
 *
 * This list will be written to the terminal when the default Gulp task is run.
 * The intention is to use direct tasks instead of a vague reference to the default task.
 */
gulp.task('default', function() {
  console.log('\nHello!\n\nThis gulpfile doesn\'t do anything by default. Use the following to see a list of available tasks:\n\n$ gulp --tasks-simple\n\n');
});
