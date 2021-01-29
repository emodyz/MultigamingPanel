const path = require('path')
const ESLintPlugin = require('eslint-webpack-plugin')
const ForkTsCheckerWebpackPlugin = require('fork-ts-checker-webpack-plugin')
const ForkTsCheckerNotifierWebpackPlugin = require('fork-ts-checker-notifier-webpack-plugin')

module.exports = env =>{
  // const inDev = !(process.env.NODE_ENV === 'production')
  return {
    stats: 'minimal',
    resolve: {
      alias: {
        '@': path.resolve('resources/js'),
      },
      extensions: ['.js', '.vue', '.ts', '.d.ts']
    },
    module: {
      rules: [
        {
          test: /\.tsx?$/,
          loader: 'ts-loader',
          exclude: /node_modules/,
          options: {
            appendTsSuffixTo: [/\.vue$/],
            transpileOnly: true
          }
        }
      ]
    },
    plugins: [
      new ESLintPlugin({
        context: 'resources/js/',
        extensions: ['js', 'vue', 'ts'],
        formatter: 'table'
      }),
      new ForkTsCheckerWebpackPlugin({
        typescript: {
          extensions: {
            vue: true
          }
        }
      }),
      new ForkTsCheckerNotifierWebpackPlugin({
        skipSuccessful: true
      }),
    ],
  }
}
