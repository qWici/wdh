import * as types from './mutation-types'

export const toggleNav = ({ commit }, status) => {
  commit(types.TOGGLE_NAV, status)
}

export const setMobileStatus = ({ commit }, status) => {
  commit(types.SET_MOBILE_STATUS, status)
}

export default {
  toggleNav,
  setMobileStatus
}
