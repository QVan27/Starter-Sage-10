import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import { wordpressPlugin, wordpressThemeJson } from '@roots/vite-plugin'
import eslint from 'vite-plugin-eslint'
import stylelint from 'vite-plugin-stylelint'

export default defineConfig({
  base: '/',
  plugins: [
    eslint({
      cache: false,
      fix: false,
      include: ['resources/assets/js/**/*.js']
    }),
    stylelint({
      fix: false,
      include: ['resources/assets/styles/**/*.scss']
    }),
    laravel({
      input: [
        'resources/assets/styles/main.scss',
        'resources/assets/js/main.js',
        // 'resources/assets/styles/editor.scss',
        // 'resources/assets/js/editor.js',
      ],
      refresh: true,
    }),

    wordpressPlugin(),

    // Generate the theme.json file in the public/build/assets directory
    // based on the Tailwind config and the theme.json file from base theme folder
    wordpressThemeJson({
      disableTailwindColors: true,
      disableTailwindFonts: true,
      disableTailwindFontSizes: true,
    }),
  ],
  resolve: {
    alias: {
      '@scripts': '/resources/assets/js',
      '@styles': '/resources/assets/css',
      '@fonts': '/resources/assets/fonts',
      '@images': '/resources/assets/images',
    },
  },
  css: {
    preprocessorOptions: {
      scss: {
        quietDeps: true,
      },
    },
  }
})
