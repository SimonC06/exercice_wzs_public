var Encore = require('@symfony/webpack-encore');
const CopyWebpackPlugin = require('copy-webpack-plugin');

Encore
// the project directory where compiled assets will be stored
    .setOutputPath('httpdocs/build/')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    .enableBuildNotifications()
    // uncomment to create hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // uncomment to define the assets of the project
    .addEntry('app', './assets/js/app.js')

    // .addStyleEntry('css/app', './assets/css/app.css')

    // uncomment if you use Sass/SCSS files
    .enableSassLoader()

    .addPlugin(new CopyWebpackPlugin([
        { from: './assets/img', to: 'images' },
    ]))
    // uncomment if you use Sass/SCSS files
    .enableSassLoader()

    // uncomment for legacy applications that require $/jQuery as a global variable
    .autoProvidejQuery();

module.exports = Encore.getWebpackConfig();