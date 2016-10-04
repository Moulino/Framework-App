module.exports = function(grunt) {

	grunt.initConfig({
		jshint: {
			options: {
				multistr: true
			},
			all: [
				'Gruntfile.js',
				'web/js/*.js',
				'web/js/Admin/*.js'
			]
		},

		uglify: {
			options: {
				mangle: false
			},
			target: {
				files: {
					'web/js/dist/script.min.js': [
						'web/bower_components/jquery/dist/jquery.min.js',
						'web/bower_components/Swiper/dist/swiper.min.js',
						'web/bower_components/Materialize/dist/js/materialize.min.js',
						'web/bower_components/angular/angular.min.js',
						'web/bower_components/angular-route/angular-route.min.js',
						'web/bower_components/angular-animate/angular-animate.min.js',
						'web/bower_components/angular-aria/angular-aria.min.js',
						'web/bower_components/angular-cookies/angular-cookies.min.js',
						'web/bower_components/angular-materialize/src/angular-materialize.js',
						'web/bower_components/ngvideo/dist/ng-video.min.js',
						'web/js/*.js'
					],

					'web/js/dist/script-admin.min.js': [
						'web/js/Admin/*.js'
					]
				}
			}
		},

		cssmin: {
			options: {
				shorthandCompacting: false,
				roundingPrecision: -1
			},
			target: {
				files: {
					'web/css/dist/styles.min.css': [
						'web/bower_components/font-awesome.min.css',
						'web/bower_components/Swiper/dist/swiper.min.css',
						'web/bower_components/Materialize/dist/css/materialize.min.css',
						'web/bower_components/angular-materialize/css/style.css',
						'web/bower_components/material-design-icons-dist/material-icons.css',
						'web/bower_components/flag-icon-css/css/flag-icon.min.css',
						'web/css/*.css'
					]
				}
			}
		},

		encoding: {
			options: {
				encoding: 'UTF-8'
			},
			files: {
				src: [
					'app/View/**/*.php',
					'web/js/**/*.js',
					'web/css/**/*.css',
					'web/index.php'
				]
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-encoding');

	grunt.registerTask('compile', ['jshint', 'encoding', 'cssmin', 'uglify']);
};