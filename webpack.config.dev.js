const prodConfig = require('./webpack.config.js');

module.exports = Object.assign({}, prodConfig, {
    mode: "development",
    devtool: 'inline-source-map',
});