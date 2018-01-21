module.exports = {
	entry: './jsx/newsletter-content.jsx',
	output: {
		path: __dirname + '/public/scripts/',
		filename: 'newsletter-content-bundle.js'
	},
	devtool: '#sourcemap',
	module: {
		loaders: [
			{
				test: /\.jsx?$/,
				exclude: /(node_modules)/,
				loaders: ['babel-loader']
			}
		]
	}
}