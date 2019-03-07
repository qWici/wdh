import store from '~/store'
import router from '../router'

export default (to, from, next) => {
  if (store.getters['global/cookieAccepted']) {
    next()
  }

  router.app.$cookieAccepted.show()
  next()
}
