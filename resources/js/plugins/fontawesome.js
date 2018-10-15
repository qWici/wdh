import Vue from 'vue'
import fontawesome from '@fortawesome/fontawesome'
import FontAwesomeIcon from '@fortawesome/vue-fontawesome'

import {
  faNewspaper
} from '@fortawesome/free-regular-svg-icons'

import {
  faUser, faLock, faSignOutAlt, faCog, faCheck, faEnvelope, faUserLock, faTv, faMicrophone
} from '@fortawesome/fontawesome-free-solid'

import {
  faGithub, faYoutube,
} from '@fortawesome/free-brands-svg-icons'

fontawesome.library.add(
  faUser, faLock, faSignOutAlt, faCog, faGithub, faCheck, faEnvelope, faUserLock, faNewspaper, faTv, faYoutube, faNewspaper, faMicrophone
)

dom.watch()

Vue.component('fa', FontAwesomeIcon)
