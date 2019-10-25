module.exports = {
  root: true,
  env: {
    node: true,
    jquery: true
  },
  extends: ['plugin:vue/essential', 'eslint:recommended', '@vue/prettier'],
  rules: {
    'no-console': process.env.NODE_ENV === 'production' ? 'error' : 'off',
    'no-debugger': process.env.NODE_ENV === 'production' ? 'error' : 'off',
    'require-atomic-updates': 'off',
    'no-undef': 'off',
    'no-prototype-builtins': 'off'
  },
  parserOptions: {
    parser: 'babel-eslint'
  }
}
