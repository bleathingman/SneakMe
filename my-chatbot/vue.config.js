const { defineConfig } = require('@vue/cli-service')
module.exports = {
  devServer: {
    proxy: {
      '^/api': {
        target: 'http://localhost/sneakme/requetes/',
        changeOrigin: true,
        pathRewrite: { '^/api': '' },
      },
    },
  },
};



