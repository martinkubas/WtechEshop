import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/js/app.js',
        'resources/js/products.js',
        'resources/js/header.js',
      ],
      refresh: true,  
    }),
  ],
  build: {
    rollupOptions: {
      input: [
        'resources/js/app.js',
        'resources/js/products.js',
        'resources/js/header.js',
      ],
    },
  },
});