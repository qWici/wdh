import * as types from './mutation-types'

export default {
  [types.FETCH_ONLINE] (state, data) {
    state.online = data
  },
  [types.FETCH_LAST_ONLINE] (state, data) {
    state.lastOnline = data
  },
  [types.FETCH_STREAM_TAGS] (state, data) {
    state.tags = data
  },
  [types.FETCH_STREAM_BY_TAG] (state, data) {
    state.byTag = data
  }
}
