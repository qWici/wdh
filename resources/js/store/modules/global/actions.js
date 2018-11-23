import * as types from './mutation-types'

export const toggleNav = ({ commit }, status) => {
  commit(types.TOGGLE_NAV, status)
}

export default {
  toggleNav
}
