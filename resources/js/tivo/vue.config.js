const { defineConfig } = require('@vue/cli-service')
module.exports = defineConfig({
  transpileDependencies: true,
  resolve: {
    extensions: ['.js', '.jsx', '.ts', '.tsx'],
  },
})
