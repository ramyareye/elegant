const path = require('path')

function resolve (dir) {
  return path.join(__dirname, dir)
}

module.exports = {
  devServer: {
    proxy: process.env.BASE_URL
  },

  outputDir: `../../public/${process.env.PUBLIC_FOLDER}`,

  // indexPath: process.env.NODE_ENV === 'production'
  //   ? '../../resources/views/${backend}.blade.php'
  //   : 'index.html',

  indexPath: process.env.NODE_ENV === 'production'
    ? '../../resources/views/backend.blade.php'
    : 'index.html',

  assetsDir: process.env.PUBLIC_FOLDER,

  lintOnSave: false,
  pages: {
    index: {
      // entry for the page
      entry: 'src/main.js',
      // the source template
      template: 'public/index.html',
      // output as dist/index.html
      filename: 'index.html',
      // when using title option,
      // template title tag needs to be <title><%= htmlWebpackPlugin.options.title %></title>
      title: process.env.TITLE,
      // chunks to include on this page, by default includes
      // extracted common chunks and vendor chunks.
      chunks: ['chunk-vendors', 'chunk-common', 'index'],
    },
  },
  configureWebpack: {
    resolve: {
      alias: {
        'vue$': 'vue/dist/vue.esm.js',
        // '@': path.resolve('src'),
        'src': path.resolve('src'),
        'elegant': path.resolve('src/elegant'),
        'assets': path.resolve('src/assets'),
        'components': path.resolve('src/components'),
        'services': path.resolve('src/services'),
        'directives': path.resolve('src/directives'),
        'vuestic-mixins': path.resolve('src/vuestic-theme/vuestic-mixins'),
        'vuestic-components': path.resolve('src/vuestic-theme/vuestic-components'),
        'vuestic-directives': path.resolve('src/vuestic-theme/vuestic-directives'),
        'vuestic-theme': path.resolve('src/vuestic-theme'),
        'data': path.resolve('src/data'),
        'vuex-store': path.resolve('src/store'),
        'view': path.resolve('src/view'),
        'partials': path.resolve('src/view/partials'),
        'services': path.resolve('src/services'),
        'gate': path.resolve('src/gate'),

        'router': resolve('src/router')
      }
    },
  },
  css: {
    loaderOptions: {
      // pass options to sass-loader
      sass: {
        // @/ is an alias to src/
        data: `@import "@/sass/shared.scss";`
      }
      // postcss: {
      //   rules: [
      //     {
      //       test: /\.css$/,
      //       use: [
      //         'style-loader',
      //         { loader: 'css-loader', options: { importLoaders: 1 } },
      //         'postcss-loader'
      //       ]
      //     }
      //   ]
      // }
    }
  }
}
