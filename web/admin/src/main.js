import Vue from 'vue'

import './config'
import router from './router'
import BeloopAdmin from './App'

import './filters'

/* eslint-disable no-new */
new Vue({
  el: '#beloop-admin',
  router,
  template: '<BeloopAdmin/>',
  components: { BeloopAdmin }
})
