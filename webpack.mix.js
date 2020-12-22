const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

let productionSourceMaps = false;

mix.typeScript('resources/js/app.ts', 'public/js')
  .vue({version: 2})
  .postCss('resources/css/app.css', 'public/css', [
    require('autoprefixer'),
    require('tailwindcss')('./tailwind.config.js')
  ])
  .webpackConfig(require('./webpack.config'))
  .babelConfig({
    plugins: ['@babel/plugin-syntax-dynamic-import'],
  })
  .version()
  .sourceMaps(productionSourceMaps, 'source-map')
