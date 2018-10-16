import Vue from 'vue'
import Vuex from 'vuex'

import auth from './modules/auth'
import lang from './modules/lang'
import streams from './modules/streams'

Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    auth,
    lang,
    streams
  }
})
