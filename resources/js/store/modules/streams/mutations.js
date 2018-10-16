import * as types from './mutation-types'

export default {
  [types.FETCH_ONLINE] (state, data) {
    state.online = data
  },
  [types.FETCH_LAST_ONLINE] (state, data) {
    state.lastOnline = data
  }
}
