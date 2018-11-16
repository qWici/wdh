import Vue from 'vue'
import Vuex from 'vuex'

import auth from './modules/auth'
import lang from './modules/lang'
import streams from './modules/streams'
import articles from './modules/articles'
import videos from './modules/videos'
import podcasts from './modules/podcasts'

Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    auth,
    lang,
    streams,
    articles,
    videos,
    podcasts
  }
})
