const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
module.exports = {
  mode: 'development',
  entry: {
    'js/app': './src/js/app.js',
    'js/inicio': './src/js/inicio.js',
    'js/roles/roles': './src/js/roles/roles.js',
    'js/login/index': './src/js/login/index.js',
    'js/registro/index': './src/js/registro/index.js',
    'js/permisos/permisos': './src/js/permisos/permisos.js',
    'js/tienda/index': './src/js/tienda/index.js',
  },
  output: {
    filename: '[name].js',
    path: path.resolve(__dirname, 'public/build')
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: 'styles.css'
    })
  ],
  module: {
    rules: [
      {
        test: /\.(c|sc|sa)ss$/,
        use: [
          {
            loader: MiniCssExtractPlugin.loader
          },
          'css-loader',
          'sass-loader'
        ]
      },
      {
        test: /\.(png|svg|jpe?g|gif)$/,
        type: 'asset/resource',
      },
    ]
  }
};