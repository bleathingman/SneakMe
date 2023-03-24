const { defineConfig } = require('@vue/cli-service')
module.exports = {
  devServer: {
    proxy: 'http://localhost/path/to/your/php/api/'
  }
}
