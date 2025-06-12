const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
module.exports = {
  mode: 'development',
  entry: {
    'js/app': './src/js/app.js',
    'js/inicio': './src/js/inicio.js',

    // tienda
    'js/views/tienda/layout': './src/js/views/tienda/layout.js',
    'js/views/tienda/index': './src/js/views/tienda/index.js',
    'js/views/tienda/publico/index': './src/js/views/tienda/publico/index.js',

    // admin
    'js/views/admin/marca/index': './src/js/views/admin/marca/index.js',
    'js/views/admin/celulares/index': './src/js/views/admin/celulares/index.js',
    'js/views/admin/usuarios/index': './src/js/views/admin/usuarios/index.js',

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