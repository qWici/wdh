import Vue from 'vue'
import Vuex from 'vuex'

import auth from './modules/auth'
import global from './modules/global'
import lang from './modules/lang'
import streams from './modules/streams'
import articles from './modules/articles'
import videos from './modules/videos'
import podcasts from './modules/podcasts'
import breadcrumbs from './modules/breadcrumbs'

Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    auth,
    global,
    lang,
    streams,
    articles,
    videos,
    podcasts,
    breadcrumbs
  }
})
