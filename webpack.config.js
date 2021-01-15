const path = require('path');
const ESLintPlugin = require('eslint-webpack-plugin');

module.exports = {
    stats: 'minimal',
    resolve: {
        alias: {
            '@': path.resolve('resources/js'),
        },
        extensions: ['.js', '.vue', '.ts', '.d.ts']
    },
    plugins: [new ESLintPlugin({
        context: 'resources/js/',
        extensions: ['js', 'vue', 'ts'],
        formatter: 'table'
    })],
}
