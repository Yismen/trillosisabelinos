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
                'resources/scss/app.scss',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
        purge({
            templates: ['blade']
        })
    ],
    resolve: {
        alias: {
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
        }
    },
});
