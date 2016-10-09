const path = require('path');

module.exports = {
    entry: {
        index: './web/admin/index.js',
    },
    output: {
        filename: '[name].js',
        path: __dirname + '/.tmp/serve'
    },
    watch: false,
    module: {
        loaders: [
            { test: /\.html$/, loader: 'ng-cache?-url&module=templates' },
            {
                test: /\.js$/,
                exclude: /node_modules/,
                loader: 'babel',
                query: {
                    presets: ['es2015']
                }
            }
        ]
    }
};