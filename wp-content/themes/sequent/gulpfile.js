var fs             = require('fs');
var gulp           = require('gulp');
var autoprefixer   = require('gulp-autoprefixer');
var cleanCSS       = require('gulp-clean-css');
var filter         = require('gulp-filter');
var include        = require('gulp-include');
var jshint         = require('gulp-jshint');
var less           = require('gulp-less');
var modernizr      = require('gulp-modernizr');
var plumber        = require('gulp-plumber');
var realFavicon    = require('gulp-real-favicon');
var sequence       = require('gulp-sequence');
var sourcemaps     = require('gulp-sourcemaps');
var svgSprite      = require('gulp-svg-sprites');
var svg2png        = require('gulp-svg2png');
var uglify         = require('gulp-uglify');

var lessImportNPM  = require('less-plugin-npm-import');

// Sprites
gulp.task('sprites', function () {
  return gulp.src('./assets/icons/*.svg')
    .pipe(plumber())
    .pipe(svgSprite({
      preview: false,
      cssFile: '../assets/less/imports/sprite.less',
      svg: {
        sprite: 'images/sprite.svg'
      },
      padding: 5
    }))
    .pipe(gulp.dest('./public'))
    .pipe(filter('**/*.svg'))
    .pipe(svg2png())
    .pipe(gulp.dest('./public'));
});

// Images
gulp.task('images', function () {
  return gulp.src('./assets/images/**/*')
    .pipe(gulp.dest('./public/images'))
    .pipe(filter('**/*.svg'))
    .pipe(svg2png())
    .pipe(gulp.dest('./public/images'));
});

// Fonts
gulp.task('fonts', function () {
  return gulp.src('./assets/fonts/**/*')
    .pipe(gulp.dest('./public/fonts'));
});

// Less
gulp.task('styles', function() {
  return gulp.src('./assets/less/*.less')
    .pipe(plumber())
    .pipe(sourcemaps.init({ loadMaps: true }))
    .pipe(less({
      plugins: [ new lessImportNPM() ]
    }))
    .pipe(autoprefixer({
      browsers: ['> 1%', 'last 2 versions', 'Firefox ESR', 'Opera 12.1', 'ie >= 10']
    }))
    .pipe(cleanCSS({
      compatibility: 'ie10',
      inline: ['none']
    }))
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest('./public/css'));
});

// JS
gulp.task('scripts', function() {
  return gulp.src('./assets/js/*.js')
    .pipe(plumber())
    .pipe(sourcemaps.init({ loadMaps: true }))
    .pipe(include({
      includePaths: [
        __dirname + '/assets/js',
        __dirname + '/node_modules'
      ]
    }))
    .pipe(jshint())
    .pipe(uglify())
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest('./public/js'));
});

// Modernizr
gulp.task('modernizr', function () {
  return gulp.src(['./public/js/*.js', './public/css/*.css'])
    .pipe(plumber())
    .pipe(modernizr({
      'tests': [
        'js',
        'touchevents'
      ],
      'options': [
        'setClasses',
        'addTest',
        'testProp',
        'fnBind'
      ]
    }))
    .pipe(uglify())
    .pipe(gulp.dest('./public/js/'))
});

// Favicon
gulp.task('favicon', function () {
  // File where the favicon markups are stored
  var FAVICON_DATA_FILE = './assets/faviconData.json';

  return realFavicon.generateFavicon({
		masterPicture: './assets/favicon.svg',
		dest: './public/favicons/',
    iconsPath: 'public/favicons/',
		design: {
			ios: {
				pictureAspect: 'backgroundAndMargin',
				backgroundColor: '#ffffff',
				margin: '14%',
				assets: {
					ios6AndPriorIcons: false,
					ios7AndLaterIcons: false,
					precomposedIcons: false,
					declareOnlyDefaultIcon: true
				}
			},
			desktopBrowser: {},
			windows: {
				pictureAspect: 'whiteSilhouette',
				backgroundColor: '#005db8',
				onConflict: 'override',
				assets: {
					windows80Ie10Tile: false,
					windows10Ie11EdgeTiles: {
						small: false,
						medium: true,
						big: false,
						rectangle: false
					}
				}
			},
			androidChrome: {
				masterPicture: {
					type: 'inline',
					content: 'PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz4KPHN2ZyB3aWR0aD0iMzAwcHgiIGhlaWdodD0iMzAwcHgiIHZpZXdCb3g9IjAgMCAzMDAgMzAwIiB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiPgogICAgPCEtLSBHZW5lcmF0b3I6IFNrZXRjaCA1Mi4xICg2NzA0OCkgLSBodHRwOi8vd3d3LmJvaGVtaWFuY29kaW5nLmNvbS9za2V0Y2ggLS0+CiAgICA8dGl0bGU+ZmF2aWNvbi1hbmRyb2lkPC90aXRsZT4KICAgIDxkZXNjPkNyZWF0ZWQgd2l0aCBTa2V0Y2guPC9kZXNjPgogICAgPGcgaWQ9ImZhdmljb24tYW5kcm9pZCIgc3Ryb2tlPSJub25lIiBzdHJva2Utd2lkdGg9IjEiIGZpbGw9Im5vbmUiIGZpbGwtcnVsZT0iZXZlbm9kZCI+CiAgICAgICAgPGNpcmNsZSBpZD0iT3ZhbCIgZmlsbD0iI0ZGRkZGRiIgY3g9IjE1MCIgY3k9IjE1MCIgcj0iMTUwIj48L2NpcmNsZT4KICAgICAgICA8ZyBpZD0iR3JvdXAiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDkxLjAwMDAwMCwgNTAuMDAwMDAwKSI+CiAgICAgICAgICAgIDxyZWN0IGlkPSJfUGF0aF8iIGZpbGw9IiM2QkM0RTgiIHg9IjQwLjkxNjY2NjciIHk9Ii0xLjc3NjM1Njg0ZS0xNCIgd2lkdGg9IjM1LjgzMzMzMzMiIGhlaWdodD0iMzUuODMzMzMzMyI+PC9yZWN0PgogICAgICAgICAgICA8cmVjdCBpZD0iX1BhdGhfMiIgZmlsbD0iIzZCQzRFOCIgeD0iNDAuOTE2NjY2NyIgeT0iODEuODMzMzMzMyIgd2lkdGg9IjM1LjgzMzMzMzMiIGhlaWdodD0iMzUuODMzMzMzMyI+PC9yZWN0PgogICAgICAgICAgICA8cG9seWxpbmUgaWQ9Il9QYXRoXzMiIGZpbGw9IiMwMDU1QjgiIHBvaW50cz0iODEuODMzMzMzMyA4MS44MzMzMzMzIDgxLjgzMzMzMzMgMTE3LjY2NjY2NyAxMTcuNjY2NjY3IDExNy42NjY2NjciPjwvcG9seWxpbmU+CiAgICAgICAgICAgIDxyZWN0IGlkPSJfUGF0aF80IiBmaWxsPSIjMDAyODU2IiB4PSI4MS44MzMzMzMzIiB5PSI0MC45MTY2NjY3IiB3aWR0aD0iMzUuODMzMzMzMyIgaGVpZ2h0PSIzNS44MzMzMzMzIj48L3JlY3Q+CiAgICAgICAgICAgIDxyZWN0IGlkPSJfUGF0aF81IiBmaWxsPSIjMDAyODU2IiB4PSI4MS44MzMzMzMzIiB5PSIxMjIuNzUiIHdpZHRoPSIzNS44MzMzMzMzIiBoZWlnaHQ9IjM1LjgzMzMzMzMiPjwvcmVjdD4KICAgICAgICAgICAgPHJlY3QgaWQ9Il9QYXRoXzYiIGZpbGw9IiMwMDI4NTYiIHg9IjQwLjkxNjY2NjciIHk9IjE2My43MDgzMzMiIHdpZHRoPSIzNS44MzMzMzMzIiBoZWlnaHQ9IjM1LjgzMzMzMzMiPjwvcmVjdD4KICAgICAgICAgICAgPHBvbHlsaW5lIGlkPSJfUGF0aF83IiBmaWxsPSIjMDA1NUI4IiBwb2ludHM9IjgxLjgzMzMzMzMgLTEuNzc2MzU2ODRlLTE0IDgxLjgzMzMzMzMgMzUuODMzMzMzMyAxMTcuNjY2NjY3IDM1LjgzMzMzMzMiPjwvcG9seWxpbmU+CiAgICAgICAgICAgIDxwb2x5bGluZSBpZD0iX1BhdGhfOCIgZmlsbD0iIzZCQzRFOCIgcG9pbnRzPSIzNS44MzMzMzMzIDc0LjQxNjY2NjcgMzUuODMzMzMzMyA0MC44NzUgMi4yOTE2NjY2NyA0MC44NzUiPjwvcG9seWxpbmU+CiAgICAgICAgICAgIDxwb2x5bGluZSBpZD0iX1BhdGhfOSIgZmlsbD0iIzZCQzRFOCIgcG9pbnRzPSIzNS44MzMzMzMzIDE1Ni4yOTE2NjcgMzUuODMzMzMzMyAxMjIuNzUgMi4yOTE2NjY2NyAxMjIuNzUiPjwvcG9seWxpbmU+CiAgICAgICAgICAgIDxwb2x5Z29uIGlkPSJfUGF0aF8xMCIgZmlsbD0iIzAwNTVCOCIgcG9pbnRzPSItMS4yMTE0NzUzNmUtMTIgNDYgLTEuMjExNDc1MzZlLTEyIDgxLjgzMzMzMzMgMzUuODMzMzMzMyAxMTcuNjY2NjY3IDM1LjgzMzMzMzMgODEuODMzMzMzMyI+PC9wb2x5Z29uPgogICAgICAgICAgICA8cG9seWdvbiBpZD0iX1BhdGhfMTEiIGZpbGw9IiMwMDU1QjgiIHBvaW50cz0iLTEuMjExNDc1MzZlLTEyIDEyNy44NzUgLTEuMjExNDc1MzZlLTEyIDE2My43MDgzMzMgMzUuODMzMzMzMyAxOTkuNTQxNjY3IDM1LjgzMzMzMzMgMTYzLjcwODMzMyI+PC9wb2x5Z29uPgogICAgICAgIDwvZz4KICAgIDwvZz4KPC9zdmc+'
				},
				pictureAspect: 'noChange',
				themeColor: '#005db8',
				manifest: {
					name: 'Sequent Learning',
					display: 'standalone',
					orientation: 'notSet',
					onConflict: 'override',
					declared: true
				},
				assets: {
					legacyIcon: false,
					lowResolutionIcons: false
				}
			},
			safariPinnedTab: {
				pictureAspect: 'silhouette',
				themeColor: '#005db8'
			}
		},
		settings: {
			scalingAlgorithm: 'Mitchell',
			errorOnImageTooSmall: false,
			readmeFile: false,
			htmlCodeFile: false,
			usePathAsIs: false
		},
		markupFile: FAVICON_DATA_FILE
	}, function() {
	});
});


gulp.task('default', sequence(
  ['favicon', 'fonts', 'images', 'sprites', 'styles', 'scripts'],
  ['modernizr']
));

gulp.task('watch', ['default'], function() {
  gulp.watch('assets/less/**/*.less', { cwd: './' }, ['styles']);
  gulp.watch('assets/js/**/*.js', { cwd: './' }, ['scripts']);
  gulp.watch('assets/icons/*.svg', { cwd: './' }, ['sprites']);
  gulp.watch('assets/images/*', { cwd: './' }, ['images']);
  gulp.watch('assets/fonts/*', { cwd: './' }, ['fonts']);
});
