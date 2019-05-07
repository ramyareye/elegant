import Vue from 'vue'

Vue.i18n.add('en', require('./en.json'))
Vue.i18n.add('fa', require('./fa.json'))

// set the start locale to use
Vue.i18n.set('fa')

// set fallback for non-translated strings
Vue.i18n.fallback('en')
