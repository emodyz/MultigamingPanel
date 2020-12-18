const path = require('path');

module.exports = {
    resolve: {
        alias: {
            vue$: path.resolve('vue/dist/vue.runtime.esm.js'),
            '@': path.resolve('resources/js'),
        },
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
