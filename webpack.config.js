const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = {
  mode: 'development',
  entry: {
    // ✅ App.js debe ser el PRIMER entry point
    'js/app': './src/js/app.js',
    'js/inicio': './src/js/inicio.js',

    'js/clientes/index': './src/js/clientes/index.js',
    'js/login/index': './src/js/login/index.js',
    'js/registro/index': './src/js/registro/index.js',
    'js/aplicaciones/aplicacion': './src/js/aplicaciones/aplicacion.js',
    'js/permisos/permisos': './src/js/permisos/permisos.js',
    'js/permisos/permiso_aplicacion': './src/js/permisos/permiso_aplicacion.js',
    'js/asignaciones/asig_permisos': './src/js/asignaciones/asig_permisos.js',

    'js/celulares/index': './src/js/celulares/index.js',
    'js/marcas/index': './src/js/marcas/index.js',
    'js/reparaciones/index': './src/js/reparaciones/index.js',
    'js/ventas/index': './src/js/ventas/index.js',
    'js/empleados/index': './src/js/empleados/index.js',
    'js/tipos_servicios/index': './src/js/tipos_servicios/index.js',
    'js/movimientos_inventario/index': './src/js/movimientos_inventario/movimientos_inventario.js',
    'js/detalle_ventas/index': './src/js/detalle_ventas/index.js',
    'js/estadisticas/index': './src/js/estadisticas/index.js',
    'js/graficas/index': './src/js/graficas/index.js',
    'js/historial_act/index': './src/js/historial_act/index.js',
    'js/mapas/index': './src/js/mapas/index.js',
    'js/rutas/index': './src/js/rutas/index.js',
  },
  output: {
    filename: '[name].js',
    path: path.resolve(__dirname, 'public/build'),
    // ✅ Limpiar el directorio de salida en cada build
    clean: true
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
      {
        // ✅ Soporte para fuentes de Bootstrap Icons
        test: /\.(woff|woff2|eot|ttf|otf)$/i,
        type: 'asset/resource',
      }
    ]
  },
  // ✅ Configuración para desarrollo
  devtool: 'source-map',
  resolve: {
    extensions: ['.js', '.scss', '.css']
  }
};