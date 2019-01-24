import Vue from 'vue'
import Vuex from 'vuex'
import createPlugin from 'logrocket-vuex'
import LogRocket from 'logrocket'

import auth from './modules/auth'
import global from './modules/global'
import lang from './modules/lang'
import streams from './modules/streams'
import articles from './modules/articles'
import videos from './modules/videos'
import podcasts from './modules/podcasts'
import breadcrumbs from './modules/breadcrumbs'

Vue.use(Vuex)

const logrocketPlugin = createPlugin(LogRocket)

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
  },
  plugins: [logrocketPlugin]
})
