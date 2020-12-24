const path = require('path');

module.exports = {
    stats: 'normal',
    resolve: {
        alias: {
            // vue$: path.resolve('vue/dist/vue.runtime.esm.js'),
            '@': path.resolve('resources/js'),
        },
        extensions: ['.js', '.vue', '.ts', '.d.ts']
    },
    module: {
        rules: [
            {
                enforce: 'pre',
                test: /\.(js|vue|ts)$/,
                loader: 'eslint-loader',
                exclude: /node_modules/
            }
        ]
    }
}
