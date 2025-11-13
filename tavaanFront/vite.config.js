import { fileURLToPath, URL } from 'node:url'
import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import vueJsx from '@vitejs/plugin-vue-jsx'
import UnpluginVueMacros from 'unplugin-vue-macros/vite';
import tailwind from '@tailwindcss/vite'

// https://vite.dev/config/
export default defineConfig({
  plugins: [
    vue(),
    vueJsx(),
      tailwind(),
    UnpluginVueMacros()

  ],
    optimizeDeps: {
    disabled: true, // TEMP: if this makes dev server run, optimizer was the issue
  },

    server: {
    port: 5000,
  },
  resolve: {
        mainFields: [
      'browser',
      'module',
      'main',
      'jsnext:main',
      'jsnext'
    ],
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url))
    },
  },
})
