const path = require('path');

module.exports = {
    entry: {
        admin: './web/admin/admin.js',
        vendor: './web/admin/vendor.js'
    },
    output: {
        filename: '[name].js'
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