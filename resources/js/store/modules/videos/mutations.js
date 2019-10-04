import * as types from './mutation-types'

export default {
  [types.FETCH_ALL] (state, data) {
    state.all = data
  },
  [types.FETCH_BY_SLUG] (state, data) {
    state.single = data
  },
  [types.FETCH_BY_CHANNEL_SLUG] (state, data) {
    state.channel = [...state.channel, ...data]
  },
  [types.FETCH_CHANNELS] (state, data) {
    state.channels = data
  },
  [types.FETCH_PAGINATE] (state, data) {
    state.paginate = [...state.paginate, ...data]
  },
  [types.CLEAR_VIDEOS] (state) {
    state.paginate = []
    state.channel = []
  },
  [types.TOGGLE_BOOKMARK] (state, status) {
    state.single = Object.assign(state.single, { bookmarked: status })
  }
}
