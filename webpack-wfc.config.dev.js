const prodConfig = require("./webpack-wfc.config.js");

module.exports = Object.assign({}, prodConfig, {
  mode: "development",
  devtool: "inline-source-map"
});
