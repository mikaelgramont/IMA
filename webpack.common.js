const path = require('path');
const CleanWebpackPlugin = require('clean-webpack-plugin');

module.exports = {
  plugins: [
    new CleanWebpackPlugin(['public/scripts']),
  ],
  entry: './jsx/newsletter-content.jsx',
  output: {
    path: path.resolve(__dirname, 'public/scripts'),
	filename: 'newsletter-content-bundle.js'
  },
	module: {
		loaders: [
			{
				test: /\.jsx?$/,
				exclude: /(node_modules)/,
				loaders: ['babel-loader']
			}
		]
	}  
};