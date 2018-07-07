const path = require('path');

module.exports = {
	entry: {
    	'newsletter-content': './jsx/newsletter-content.jsx',
    	'vote-animation': './jsx/vote-animation/index.jsx'
  	},
  	output: {
    	path: path.resolve(__dirname, 'public/scripts'),
		filename: '[name]-bundle.js'
  	},
    mode: 'production',
    module: {
        rules: [
            {
                test: /\.jsx?$/,
                use: {
                    loader: "babel-loader"
                }
            }
        ]
    },

};