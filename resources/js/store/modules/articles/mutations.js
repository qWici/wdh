import * as types from './mutation-types'

export default {
  [types.FETCH_ALL] (state, data) {
    state.all = data
  }
}
