import Vue from 'vue'
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

import {
  faNewspaper, faBookmark
} from '@fortawesome/free-regular-svg-icons'

import {
  faUser, faLock, faSignOutAlt, faCog, faCheck, faEnvelope, faUserLock, faTv, faMicrophone, faUpload, faBars,
  faWindowClose, faSearch, faTimesCircle, faBookmark as fasBookmark, faHome, faMagic
} from '@fortawesome/free-solid-svg-icons'

import {
  faGithub, faYoutube
} from '@fortawesome/free-brands-svg-icons'

library.add(
  faUser, faLock, faSignOutAlt, faCog, faGithub, faCheck, faEnvelope, faUserLock, faNewspaper, faTv, faYoutube,
  faNewspaper, faMicrophone, faUpload, faBars, faWindowClose, faSearch, faTimesCircle, faBookmark, fasBookmark, faHome,
  faMagic
)

Vue.component('fa', FontAwesomeIcon)
