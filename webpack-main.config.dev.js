const prodConfig = require("./webpack-main.config.js");

module.exports = Object.assign({}, prodConfig, {
  mode: "development",
  devtool: "inline-source-map"
});
