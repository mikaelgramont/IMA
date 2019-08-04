const prodConfig = require("./webpack-wbc.config.js");

module.exports = Object.assign({}, prodConfig, {
  mode: "development",
  devtool: "inline-source-map"
});
