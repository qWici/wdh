import Vue from 'vue'
import { library } from '@fortawesome/fontawesome-svg-core'
import FontAwesomeIcon from '@fortawesome/vue-fontawesome'

import {
  faNewspaper
} from '@fortawesome/free-regular-svg-icons'

import {
  faUser, faLock, faSignOutAlt, faCog, faCheck, faEnvelope, faUserLock, faTv, faMicrophone
} from '@fortawesome/free-solid-svg-icons'

import {
  faGithub, faYoutube
} from '@fortawesome/free-brands-svg-icons'

library.add(
  faUser, faLock, faSignOutAlt, faCog, faGithub, faCheck, faEnvelope, faUserLock, faNewspaper, faTv, faYoutube, faNewspaper, faMicrophone
)

Vue.component('fa', FontAwesomeIcon)
