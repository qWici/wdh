import store from '~/store'

export default async (to, from, next) => {
  if (store.getters['global/navOpened']) {
    await store.dispatch('global/toggleNav', false)
    next()
  }
  next()
}
