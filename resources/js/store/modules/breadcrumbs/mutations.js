import * as types from './mutation-types'

export default {
  [types.SET_BREADCRUMBS] (state, breadcrumbs) {
    state.breadcrumbs = breadcrumbs
  }
}
