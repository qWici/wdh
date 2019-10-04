import * as types from './mutation-types'

export default {
  [types.FETCH_ALL] (state, data) {
    state.all = data
  },
  [types.FETCH_BY_SLUG] (state, data) {
    state.single = data
  },
  [types.FETCH_BY_AUTHOR_SLUG] (state, data) {
    state.author = [...state.author, ...data]
  },
  [types.FETCH_AUTHORS] (state, data) {
    state.authors = data
  },
  [types.FETCH_PAGINATE] (state, data) {
    state.paginate = [...state.paginate, ...data]
  },
  [types.CLEAR_ARTICLES] (state) {
    state.paginate = []
    state.author = []
  },
  [types.TOGGLE_BOOKMARK] (state, status) {
    state.single = Object.assign(state.single, { bookmarked: status })
  }
}
