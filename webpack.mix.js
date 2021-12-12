const dotenvExpand = require('dotenv-expand');
dotenvExpand(require('dotenv').config({ path: '../../.env',/* debug: true*/}));

const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('../../public').mergeManifest();

mix.js(__dirname + '/Resources/assets/js/app.js', 'js/openfoodfactssearchproducts.js')
    .postCss(__dirname + '/Resources/assets/css/bootstrap.css', 'css/openfoodfactssearchproducts.css')
    .postCss(__dirname + '/Resources/assets/css/main.css', 'css/openfoodfactssearchproducts.css')
    .postCss(__dirname + '/Resources/assets/css/app.css', 'css/openfoodfactssearchproducts.css')

if (mix.inProduction()) {
    mix.version();
}
