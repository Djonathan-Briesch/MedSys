// ESLint config para projeto React com Vite + Prettier

import js from '@eslint/js' // Regras básicas recomendadas do ESLint
import prettierPlugin from 'eslint-plugin-prettier' // Plugin que integra Prettier com ESLint
import react from 'eslint-plugin-react' // Regras específicas para React
import reactHooks from 'eslint-plugin-react-hooks' // Regras para hooks do React
import reactRefresh from 'eslint-plugin-react-refresh' // Regras para hot reload React Refresh (Vite)
import simpleImportSort from 'eslint-plugin-simple-import-sort' // Plugin para ordenar imports automaticamente
import globals from 'globals' // Variáveis globais (ex: browser)

export default [
  // =====================
  // Seção de ignorados
  // =====================
  {
    ignores: ['dist', 'build', 'node_modules'] // Ignora a pasta de build para não lintear arquivos gerados
  },
  // =====================
  // Configuração principal para arquivos JS e JSX
  // =====================
  {
    files: ['**/*.{js,jsx}'], // Aplica ESLint somente nesses arquivos
    // =====================
    // Opções de linguagem e ambiente
    // =====================
    languageOptions: {
      ecmaVersion: 2020, // Suporta ES2020
      globals: globals.browser, // Variáveis globais do browser disponíveis (ex: window)
      parserOptions: {
        ecmaVersion: 'latest', // Permite uso da sintaxe JS mais recente
        ecmaFeatures: { jsx: true }, // Suporta JSX (React)
        sourceType: 'module' // Usa import/export do ES Modules
      }
    },
    // =====================
    // Plugins instalados para regras extras
    // =====================
    plugins: {
      react, // Plugin React (regras JSX etc)
      prettier: prettierPlugin, // Integra Prettier no ESLint
      'react-hooks': reactHooks, // Regras específicas para hooks
      'react-refresh': reactRefresh, // Regras para hot reload do React com Vite
      'simple-import-sort': simpleImportSort // Ordenação automática dos imports
    },
    // ============================
    // Configurações do React
    // ============================
    settings: {
      react: {
        version: 'detect' // Detecta a versão do React automaticamente a partir do package.json
      }
    },

    // =====================
    // Regras do ESLint e plugins
    // =====================
    rules: {
      // Regras recomendadas do ESLint e plugins React e acessibilidade
      ...js.configs.recommended.rules, // Regras básicas do ESLint
      ...react.configs.recommended.rules, // Regras recomendadas para React
      ...reactHooks.configs.recommended.rules, // Regras para hooks do React

      // Qualidade e padronização
      eqeqeq: ['error', 'always'], // Usa sempre === e !==
      'no-console': 'warn', // Aviso para evitar console.log no código final
      'no-debugger': 'error', // Proíbe debugger no código

      camelcase: ['error', { properties: 'always' }], // Obriga usar camelCase em variáveis e propriedades

      // Regras específicas para JSX/React
      'react/jsx-boolean-value': ['error', 'never'], // <Comp ativo /> em vez de ativo={true}
      'react/self-closing-comp': 'error', // Usa tags autoclosing quando possível <div />
      'react/jsx-curly-spacing': ['error', { when: 'never', children: true }], // Espaçamento nas chaves do JSX

      // React Refresh para hot reload no Vite
      'react-refresh/only-export-components': [
        'warn',
        { allowConstantExport: true }
      ],

      // Organiza os imports automaticamente em ordem alfabética e por grupos
      'simple-import-sort/imports': 'error',
      'simple-import-sort/exports': 'error',

      // Integra Prettier ao ESLint: formatação deve estar correta
      'prettier/prettier': 'error',

      // Evita variáveis declaradas e não usadas (com exceção para nomes que começam com maiúscula ou _)
      'no-unused-vars': ['error', { varsIgnorePattern: '^[A-Z_]' }],

      // Desativa a exigência de importar o React ao usar JSX
      'react/react-in-jsx-scope': 'off'
    }
  }
]