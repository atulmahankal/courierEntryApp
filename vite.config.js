import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { viteStaticCopy } from 'vite-plugin-static-copy'

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
    }),
    viteStaticCopy({
      targets: [
        {
          src: 'vendor/almasaeed2010/adminlte/dist/*',
          dest: '../vendor/adminlte'
        },
        {
          src: 'vendor/almasaeed2010/adminlte/plugins/*',
          dest: '../vendor'
        },
      ]
    }),
  ],
});
