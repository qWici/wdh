import * as types from './mutation-types'
import axios from 'axios'

export const toggleNav = ({ commit }, status) => {
  commit(types.TOGGLE_NAV, status)
}

export const setMobileStatus = ({ commit }, status) => {
  commit(types.SET_MOBILE_STATUS, status)
}

export const search = async ({ commit }, query) => {
  const { data } = await axios.post('/api/search', { q: query })

  commit(types.SEARCH, data)
}

export default {
  toggleNav,
  setMobileStatus,
  search
}
