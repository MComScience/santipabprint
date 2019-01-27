const path = require('path');
const UglifyJsPlugin = require("uglifyjs-webpack-plugin");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const OptimizeCSSAssetsPlugin = require("optimize-css-assets-webpack-plugin");
const ExtractTextPlugin = require("extract-text-webpack-plugin");

module.exports  = {
    entry: {
        app: path.resolve(__dirname, './frontend/web/js/app.js'),
        waitMe: path.resolve(__dirname, './frontend/web/js/waitMe/waitMe.min.js'),
        quoPrint: path.resolve(__dirname, './frontend/web/js/quo-print.js'),
        style: path.resolve(__dirname, './frontend/web/css/style.less'),
        product_grid: path.resolve(__dirname, './frontend/web/css/product-grid.css'),
        site: path.resolve(__dirname, './frontend/web/css/site.css'),
        mobilemenu: path.resolve(__dirname, './frontend/web/css/mobile-menu.css'),
        animate: path.resolve(__dirname, './frontend/web/css/animate.css'),
        waitMe: path.resolve(__dirname, './frontend/web/js/waitMe/waitMe.min.css'),
        quotation: path.resolve(__dirname, './frontend/web/css/quotation.css'),
        checkboxStyle: path.resolve(__dirname, './frontend/web/css/checkbox-style.css'),
    },
    output: {
        filename: '[name].js',
        path: path.resolve(__dirname, './frontend/web/bundle'),
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: [/node_modules/],
                use: [
                    {
                        loader: 'babel-loader',
                        options: { presets: ['latest'] }
                    }
                ]
            },
            {
                test: /\.less$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    'css-loader',
                    'less-loader'
                ]            
            },
            {
                test: /\.css$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    'css-loader'
                ]
            },
        ]
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: "[name].css",
            allChunks: true
        })
    ],
    optimization: {
        minimizer: [
            new UglifyJsPlugin({
                cache: true,
                parallel: true,
                sourceMap: true
            }),
            new OptimizeCSSAssetsPlugin({})
        ]
    },
    devtool: 'source-map',
    mode: 'production'
};