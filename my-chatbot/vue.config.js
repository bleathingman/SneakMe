const { defineConfig } = require('@vue/cli-service')
module.exports = {
  devServer: {
    proxy: {
      '^/api': {
        target: 'http://localhost/test_44/requetes/',
        changeOrigin: true,
        pathRewrite: { '^/api': '' },
      },
    },
  },
};



