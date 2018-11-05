import * as types from './mutation-types'

export default {
  [types.FETCH_ALL] (state, data) {
    state.all = data
  },
  [types.FETCH_BY_ID] (state, data) {
    state.single = data
  },
  [types.FETCH_PAGINATE] (state, data) {
    state.paginate = [...state.paginate, ...data]
  },
  [types.CLEAR_VIDEOS] (state) {
    state.paginate = []
  }
}
