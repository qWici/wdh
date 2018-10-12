import Vue from 'vue'
import fontawesome from '@fortawesome/fontawesome'
import FontAwesomeIcon from '@fortawesome/vue-fontawesome'

import {
  faNewspaper
} from '@fortawesome/fontawesome-free-regular/shakable.es'

import {
  faUser, faLock, faSignOutAlt, faCog, faCheck, faEnvelope, faUserLock, faTv,
} from '@fortawesome/fontawesome-free-solid/shakable.es'

import {
  faGithub, faYoutube,
} from '@fortawesome/fontawesome-free-brands/shakable.es'

fontawesome.library.add(
  faUser, faLock, faSignOutAlt, faCog, faGithub, faCheck, faEnvelope, faUserLock, faNewspaper, faTv, faYoutube, faNewspaper,
)

Vue.component('fa', FontAwesomeIcon)
