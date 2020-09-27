const path = require("path");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const autoprefixer = require("autoprefixer");

module.exports = {
    entry: ["babel-polyfill", "./resources/scripts/index.js"],
    output: {
        filename: "app.js",
        path: path.resolve(__dirname, "dist", "assets", "js"),
        publicPath: "./dist/assets",
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: [/node_modules/, /vendor/],
                use: {
                    loader: "babel-loader",
                    options: {
                        presets: ["@babel/preset-env"],
                    },
                },
            },
            {
                test: /\.scss$/,
                use: [
                    "style-loader",
                    MiniCssExtractPlugin.loader,
                    "css-loader?url=false",
                    {
                        loader: "postcss-loader",
                        options: {
                            autoprefixer: {
                                browser: ["last 4 versions"],
                            },
                            plugins: () => [autoprefixer],
                        },
                    },
                    "sass-loader",
                ],
            },
        ],
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: "../styles/[name].css",
        }),
    ],
};
