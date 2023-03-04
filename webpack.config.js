const Encore = require('@symfony/webpack-encore')
const CompressionPlugin = require('compression-webpack-plugin')
const path = require('path')

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
	Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev')
}

const fullConfig = Encore
	// directory where compiled assets will be stored
	.setOutputPath('public/build/')
	// public path used by the web server to access the output path
	.setPublicPath('/build')
	// only needed for CDN's or subdirectory deploy
	//.setManifestKeyPrefix('build/')

	/*
	 * ENTRY CONFIG
	 *
	 * Each entry will result in one JavaScript file (e.g. app.js)
	 * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
	 */
	.addEntry('app', './assets/app.js')

	.addPlugin(new CompressionPlugin())

	// enables the Symfony UX Stimulus bridge (used in assets/bootstrap.js)
	.enableStimulusBridge('./assets/controllers.json')

	// When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
	.splitEntryChunks()

	// will require an extra script tag for runtime.js
	// but, you probably want this, unless you're building a single-page app
	.enableSingleRuntimeChunk()

	/*
	 * FEATURE CONFIG
	 *
	 * Enable & configure other features below. For a full
	 * list of features, see:
	 * https://symfony.com/doc/current/frontend.html#adding-more-features
	 */
	.cleanupOutputBeforeBuild()
	.enableBuildNotifications()
	.enableSourceMaps(!Encore.isProduction())
	// enables hashed filenames (e.g. app.abc123.css)
	.enableVersioning(Encore.isProduction())

	// configure Babel
	// .configureBabel((config) => {
	//     config.plugins.push('@babel/a-babel-plugin');
	// })

	// enables and configure @babel/preset-env polyfills
	//.configureBabelPresetEnv((config) => {
	//  config.useBuiltIns = 'usage';
	//  config.corejs = '3.23';
	//})

	// enables Sass/SCSS support
	.enableSassLoader()
	.enableVueLoader()
	.getWebpackConfig()

// uncomment if you use TypeScript
//.enableTypeScriptLoader()

// uncomment if you use React
//.enableReactPreset()

// uncomment to get integrity="..." attributes on your script & link tags
// requires WebpackEncoreBundle 1.4 or higher
//.enableIntegrityHashes(Encore.isProduction())

// uncomment if you're having problems with a jQuery plugin
//.autoProvidejQuery()
// fullConfig.devServer = {
//     host: 'localhost',
//     compress: true,
//     hot: true,
//     watchFiles : {
//         paths : ['src/**/*.php', 'templates/**/*'],
//         options: {
//             usePolling: false,
//           },
//     }
// };
fullConfig.module = {
	rules: [
		{
			test: /\.vue$/,
			loader: 'vue-loader',
		},
		{
			test: /\.jsx?/i,
			loader: 'babel-loader',
			exclude: /node_modules/,
			options: {
				presets: ['@babel/preset-env'],
				plugins: [['transform-react-jsx', { pragma: 'h' }]],
			},
		},
		{
			test: /\.s[ac]ss$/i,
			use: [
				// Creates `style` nodes from JS strings
				'style-loader',
				// Translates CSS into CommonJS
				'css-loader',
				// Compiles Sass to CSS
				'sass-loader',
			],
		},
	],
}

fullConfig.resolve = {
	alias: {
		react: 'preact-compat',
		'react-dom': 'preact-compat',
	},
}
module.exports = fullConfig
