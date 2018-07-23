 var path = require('path')
var utils = require('./utils')
var config = require('../config')
var vueLoaderConfig = require('./vue-loader.conf')

function resolve (dir) {
  return path.join(__dirname, '..', dir)
}

module.exports = {
  entry: {
    app: './src/main.js'
  },
  output: {
    path: config.build.assetsRoot,
    filename: '[name].js',
    publicPath: process.env.NODE_ENV === 'production'
      ? config.build.assetsPublicPath
      : config.dev.assetsPublicPath
  },
  resolve: {
    extensions: ['.js', '.vue', '.scss', '.sass', '.css', '.ttf'],
    modules: [
      resolve('src'),
      resolve('node_modules')
    ],
    alias: {
      'vue$': 'vue/dist/vue.common.js',
      'src': resolve('src'),
      'assets': resolve('src/assets'),
      'components': resolve('src/components'),
      'node_modules': resolve('node_modules'),
      'FONTS': path.join(__dirname, 'src/assesssts/webfonts')
    }
  },
  module: {
    rules: [
      {
        test: /\.(js|vue)$/,
        loader: 'eslint-loader',
        enforce: "pre",
        include: [resolve('src'), resolve('test')],
        options: {
          formatter: require('eslint-friendly-formatter')
        }
      },
      {
        test: /\.vue$/,
        loader: 'vue-loader',
        options: vueLoaderConfig
      },
      {
        test: /\.js$/,
        loader: 'babel-loader',
        // include: [resolve('src'), resolve('test')]
        include: [
         resolve('src'),
         resolve('test'),
         resolve('node_modules/vue-echarts'),
         resolve('node_modules/resize-detector')
       ]
      },
      {
        test: /\.(png|jpe?g|gif|svg)(\?.*)?$/,
        loader: 'url-loader',
        query: {
          limit: 10000,
          name: utils.assetsPath('img/[name].[hash:7].[ext]')
        }
      },
      {
        test: /\.(woff2?|eot|ttf|otf)(\?.*)?$/,
        loader: 'url-loader',
        query: {
          limit: 10000,
          name: utils.assetsPath('fonts/[name].[hash:7].[ext]'),
          // resolve: false,
          publicPath: process.env.NODE_ENV === 'production' ? '../../' : '/'
        }
      },
      {
        test: /\.(scss|sass)$/,
        // loaders: ['style-loader', 'css-loader', 'resolve-url-loader', 'sass-loader?sourceMap'],
        // include: [resolve('node_modules/bootstrap/scss/bootstrap')],
        use: ['style-loader', 'css-loader', 'sass-loader?sourceMap']
        // {
        //   loader: 'postcss-loader', // Run post css actions
        //   options: {
        //     plugins: function () { // post css plugins, can be exported to postcss.config.js
        //       return [
        //         require('precss'),
        //         require('autoprefixer')
        //       ];
        //     }
        //   }
        // }
      }
    ]
  }
}
