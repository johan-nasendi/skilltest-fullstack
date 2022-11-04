const mix = require('laravel-mix');

module.exports = {
    entry: {
        app: './resources/js/app.js',
    },
    devtool: 'inline-source-map',
    devServer: {
        hot: true,
    },

};

mix.js('resources/js/app.js', 'public/js')
    .vue({ version: 3 })
    .sass('resources/sass/app.scss', 'public/css');