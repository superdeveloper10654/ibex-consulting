const argv = require('yargs').argv;
const fs = require('fs');
const mix = require('laravel-mix');
const lodash = require("lodash");
const WebpackRTLPlugin = require('webpack-rtl-plugin');
const rimraf = require('rimraf');

const folder = {
    src: "resources/", // source files
    dist: "public/", // build files
    dist_assets: "public/assets/" //build assets files
};

const folder_central = {
    src: "resources/app-central/web", // source files
    dist: "public/", // build files
    dist_assets: "public/assets/" //build assets files
};

const folder_central_admin = {
    src: "resources/app-central/admin", // source files
    dist: "public/", // build files
    dist_assets: "public/assets/" //build assets files
};

const folder_tenant = {
    src: "resources/app-tenant", // source files
    dist: "public/", // build files
    dist_assets: "public/assets/" //build assets files
};

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.options({
    terser: {
       terserOptions: {
          keep_fnames: true
       }
    }
});

// copy all images 
// var out = folder.dist_assets + "images";
// mix.copyDirectory(folder.src + "images", out);

// css are common for central and tenants
mix.sass(`${folder.src}/scss/app.scss`, folder.dist_assets + "css").options({ processCssUrls: false }).minify(folder.dist_assets + "css/app.css")
    // central
    .combine([
        `${folder.src}/assets/js/common/*`,
        `${folder_central.src}/js/components/*`,
        `${folder_central.src}/js/app.js`,
    ], folder_central.dist_assets + "js/app-central.min.js")

    // central admin
    .combine([
        `${folder.src}/assets/js/common/*`,
        `${folder_central_admin.src}/js/components/*`,
        `${folder_central_admin.src}/js/app.js`,
    ], folder_central_admin.dist_assets + "js/app-central-admin.min.js")

    // tenants
    .js(`${folder_tenant.src}/js/Channels.js`, `${folder_tenant.dist}/js/tenant-channels-temp.js`)
    .combine([
        `${folder.src}/assets/js/common/*`,
        `${folder_tenant.dist}/js/tenant-channels-temp.js`, // should always be on top
        `${folder_tenant.src}/js/partials/*`,
        // `${folder_tenant.src}/js/components/*`,
        `${folder_tenant.src}/js/components/resource-page/*`,
        `${folder_tenant.src}/js/app.js`,
    ], folder_tenant.dist_assets + "js/app-tenant.min.js")
    .then(() => {
        let files_to_remove = [
            `${folder_tenant.dist}/js/tenant-channels-temp.js`,
            `${folder_tenant.dist}/js/tenant-channels-temp.js.LICENSE.txt`
        ];

        // remove files only for prod action because 'watch' action returns error
        if (process.env.npm_lifecycle_script.includes('production') && files_to_remove.length) {
            for (let i = 0; i < files_to_remove.length; i++) {
                let file = files_to_remove[i];

                if (fs.existsSync(file)) {
                    rimraf(file);
                }
            }
        }
    });