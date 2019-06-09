const path = require('path');

module.exports = {
  entry: {
    app: [
      '@babel/polyfill',
      './assets/javascript/index.js'
    ]
  },
  output: {
    filename: 'app.bundle.js',
    path: path.resolve(__dirname, 'public/js')
  },
  module: {
    rules: [{
      test: /\.js$/,
      exclude: [/node_modules/, /vendor/],
      use: {
        loader: 'babel-loader',
        options: {
          presets: ['@babel/preset-env']
        }
      }
    }]
  }
}