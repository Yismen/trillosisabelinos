import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';
import purge from '@erbelion/vite-plugin-laravel-purgecss';

export default defineConfig({
    server: {
        hmr: {
            host: 'localhost',
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/sass/welcome.scss',
                'resources/js/welcome.js',
                'resources/css/filament.css',
            ],
            refresh: true,
        }),
        // purge({
        //     templates: ['blade'],
        //     paths: [
        //         'resources/views/**/*.blade.php',
        //         'resources/{js,views}/**/*.vue',
        //         'vendor/**/*.{blade.php,php,js,jsx,ts,tsx,vue}',
        //     ],
        //     // safelist: [/filament$/, /^filament/, 'tw'],
        //     // variables: true,
        //     // rejected: true,
        // })
    ],
    resolve: {
        alias: {
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
        }
    },
});
