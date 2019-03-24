const path = require("path");

const generalConfig = require("./webpack.config.js");

module.exports = Object.assign({}, generalConfig, {
  entry: {
    "registration": "./jsx/wfc/registration/index.jsx",
  },
  output: {
    path: path.resolve(__dirname, "wfc/scripts"),
    filename: "[name]-bundle.js"
  }
});
