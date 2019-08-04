const path = require("path");

const generalConfig = require("./webpack.config.js");

module.exports = Object.assign({}, generalConfig, {
  entry: {
    "registration": "./jsx/wbc/registration/index.jsx",
  },
  output: {
    path: path.resolve(__dirname, "wbc/scripts"),
    filename: "[name]-bundle.js"
  }
});
