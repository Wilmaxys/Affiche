var Encore = require("@symfony/webpack-encore");

Encore
    .copyFiles({
        from: './assets/images',
        // optional target path, relative to the output dir
        to: 'images/[path][name].[ext]',
        // only copy files matching this pattern
        pattern: /\.(png|jpg|jpeg)$/
    })
    // directory where all compiled assets will be stored
    .setOutputPath("public/build/")
    // what's the public path to this directory (relative to your project's document root dir)
    .setPublicPath("/")
    // empty the outputPath dir before each build
    .cleanupOutputBeforeBuild()
    // enable react in babel
    .enableReactPreset()
    // so we don't need to deal with runtime.js
    .disableSingleRuntimeChunk()
    // will output as app/Resources/webpack/server-bundle.js
    .addEntry('app', './assets/js/app.js')
    .addEntry('nozAffiche', './assets/js/nozAffiche.js')
    .addEntry("preRender", "./assets/js/preRender.js");
// export the final configuration

module.exports = Encore.getWebpackConfig();