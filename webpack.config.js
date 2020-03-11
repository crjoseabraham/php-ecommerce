const path = require("path");

module.exports = {
    entry: "./resources/scripts/index.js",
    output: {
        filename: "app.js",
        path: path.resolve(__dirname, "public", "assets", "scripts")
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: [/node_modules/, /vendor/],
                use: {
                    loader: "babel-loader",
                    options: {
                        presets: ["@babel/preset-env"]
                    }
                }
            }
        ]
    }
};
