import * as types from './mutation-types'

export default {
  [types.FETCH_ONLINE] (state, data) {
    state.online = [...state.online, ...data]
  },
  [types.FETCH_LAST_ONLINE] (state, data) {
    state.lastOnline = data
  },
  [types.FETCH_STREAM_TAGS] (state, data) {
    state.tags = data
  },
  [types.FETCH_STREAM_BY_TAG] (state, data) {
    state.byTag = data.sort((a, b) => {
      return b.online - a.online
    })
  },
  [types.CLEAR_STREAMS] (state) {
    state.online = []
  },
  [types.FETCH_BY_SLUG] (state, data) {
    state.single = data
  },
  [types.TOGGLE_BOOKMARK] (state, status) {
    state.single = Object.assign(state.single, { bookmarked: status })
  }
}
