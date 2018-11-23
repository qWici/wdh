import * as types from './mutation-types'

export default {
  [types.TOGGLE_NAV] (state, status) {
    if (status === undefined) {
      state.navOpened = !state.navOpened
      return
    }

    state.navOpened = status
  }
}
