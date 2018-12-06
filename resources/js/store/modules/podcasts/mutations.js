import * as types from './mutation-types'

export default {
  [types.FETCH_ALL] (state, data) {
    state.all = data
  },
  [types.FETCH_BY_SLUG] (state, data) {
    state.single = data
  },
  [types.FETCH_BY_SHOW_SLUG] (state, data) {
    state.show = [...state.show, ...data]
  },
  [types.FETCH_PAGINATE] (state, data) {
    state.paginate = [...state.paginate, ...data]
  },
  [types.CLEAR_PODCASTS] (state) {
    state.paginate = []
    state.show = []
  },
  [types.TOGGLE_BOOKMARK] (state, status) {
    state.single = Object.assign(state.single, { bookmarked: status })
  }
}
