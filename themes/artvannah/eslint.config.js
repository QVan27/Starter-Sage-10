import js from '@eslint/js'
import importPlugin from 'eslint-plugin-import'
import globals from 'globals'

export default [
  js.configs.recommended,

  {
    files: ['resources/assets/js/**/*.js'],

    languageOptions: {
      ecmaVersion: 'latest',
      sourceType: 'module',

      globals: {
        ...globals.browser,
        ...globals.jquery,

        wp: 'readonly',
        ga: 'readonly',
      },
    },

    plugins: {
      import: importPlugin,
    },

    rules: {
      'no-unused-vars': 'warn',
      'no-console': ['error', { allow: ['warn', 'error', 'log'] }],
      'quotes': ['error', 'single'],
      'prefer-const': 'error',
      'no-var': 'error',
      'camelcase': 'off',
      'no-underscore-dangle': 'off',
      'no-shadow': 'off',
      'import/no-unresolved': 'off',
    },
  },
]
