const path = require("path");

const generalConfig = require("./webpack.config.js");

module.exports = Object.assign({}, generalConfig, {
  entry: {
    "newsletter-content": "./jsx/main/newsletter-content.jsx",
    "vote-animation": "./jsx/main/vote-animation/index.jsx",
    "2019-french-championships": "./jsx/main/registration/2019-french-championships/index.jsx",
  },
  output: {
    path: path.resolve(__dirname, "public/scripts"),
    filename: "[name]-bundle.js"
  }
});
