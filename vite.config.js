import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import reactRefresh from '@vitejs/plugin-react-refresh';

import rollupConfig from './rollup.config.js';

export default defineConfig({
    server: {
        proxy: "https://the7ofdiamonds.development",
        hmr: {
            protocol: 'ws',
            host: 'the7ofdiamonds.development',
        },
        watch: {
            //     usePolling: true,
            //     interval: 100,
            include: ['src/**/*.jsx', 'src/**/*.js'],
        },
    },
    publicDir: false,
    build: {
        watch: {
            include: ['src/**/*.jsx', 'src/**/*.js'],
        },
        manifest: true,
        sourcemap: true,
        emptyOutDir: true,
        modulePreload: false,
        outDir: 'dist/',
        assetsDir: 'js',
        input: './src/index.jsx',
        rollupOptions: rollupConfig
    },
    plugins: [
        react(),
        reactRefresh(),
    ],
    resolve: {
        alias: {
            '/@/': new URL('src/', import.meta.url).pathname + '/',
        },
    },
});
