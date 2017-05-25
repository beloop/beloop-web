const path = require('path');
const webpack = require('webpack');
const LodashModuleReplacementPlugin = require('lodash-webpack-plugin');

module.exports = {
  context: path.resolve(__dirname, 'admin'),
  entry: './index.jsx',
  output: {
    path: path.resolve(__dirname, 'js'),
    filename: 'admin.min.js'
  },
  module: {
    loaders: [
      {
        test: /\.js$/,
        loader: 'babel-loader',
        exclude: /node_modules/,
        query: {
          plugins: ['lodash'],
          presets: ['es2015']
        }
      },
      {
        test: /\.jsx$/,
        loader: 'babel-loader',
        exclude: /node_modules/,
        query: {
          plugins: ['lodash'],
          presets: ['es2015']
        }
      }
    ]
  },
  resolve: {
    alias: {
      Components: path.resolve(__dirname, 'admin/components'),
      Config: path.resolve(__dirname, 'admin/config'),
      Services: path.resolve(__dirname, 'admin/services'),
    },
    extensions: [
      '.js',
      '.jsx'
    ]
  },
  plugins: [
    new LodashModuleReplacementPlugin(),
    new webpack.optimize.CommonsChunkPlugin({
      name: 'vendor',
      filename: 'vendor.min.js'
    })/*,
    new webpack.optimize.UglifyJsPlugin({
      compress: {
        warnings: false
      }
    })*/
  ]
};