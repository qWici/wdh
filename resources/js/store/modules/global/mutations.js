import * as types from './mutation-types'

export default {
  [types.TOGGLE_NAV] (state, status) {
    if (state.navOpened === status) { return }
    if (status === undefined) {
      state.navOpened = !state.navOpened
      return
    }

    state.navOpened = status
  },
  [types.SET_MOBILE_STATUS] (state, status) {
    state.isMobile = status
  },
  [types.SEARCH] (state, data) {
    state.search = data
  },
  [types.GET_LATEST_ITEMS] (state, data) {
    state.latest = [...state.latest, ...data]
  },
  [types.GET_USER_BOOKMARKS] (state, data) {
    state.bookmarks = [...state.bookmarks, ...data]
  },
  [types.CLEAR_GLOBAL] (state) {
    state.bookmarks = []
  }
}
