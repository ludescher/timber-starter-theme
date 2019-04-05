var Encore = require('@symfony/webpack-encore');

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Add 1 entry for each "page" of your app
     * (including one that's included on every page - e.g. "app")
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if you JavaScript imports CSS.
     */
    .addEntry('app', './assets/js/app.js')
    //.addEntry('page1', './assets/js/page1.js')
    //.addEntry('page2', './assets/js/page2.js')

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // uncomment if you use Sass/SCSS files
    .enableSassLoader(function(options) { 
        // https://github.com/sass/node-sass#options 
        //options.includePaths = [...] 
    }, { 
        // set optional Encore-specific options 
        resolveUrlLoader: false 
    })

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment if you're having problems with a jQuery plugin
    .autoProvidejQuery()

    // uncomment if you use API Platform Admin (composer req api-admin)
    //.enableReactPreset()
    //.addEntry('admin', './assets/js/admin.js')

    .configureDefinePlugin((options) => {
        options.__DEV__ = JSON.stringify(!Encore.isProduction());
    })

    .configureBabel(function(babelConfig) {
        babelConfig.plugins = [
            "transform-object-rest-spread",
            "transform-class-properties",
            "transform-async-to-generator"
        ];

        babelConfig.presets = [
            [
                "@babel/preset-env", {
                    "targets": {
                        "node": "current"
                    }
                }
            ]
        ];
    })
;

let config = Encore.getWebpackConfig();

if (!Encore.isProduction()) {
    const BrowserSyncPlugin = require('browser-sync-webpack-plugin')
    config.plugins.push(
        new BrowserSyncPlugin({
            // browse to http://localhost:3000/ during development,
            // ./public directory is being served
            host: '127.0.0.1',
            proxy: 'http://localhost/wordpress/',
            port: 3000,
            //server: { baseDir: ['public'] }
        })
    );
}

module.exports = config;