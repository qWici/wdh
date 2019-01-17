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

export const toggleBookmarked = async ({ commit }, { id, type }) => {
  const { data } = await axios.post('/api/bookmark/toggle', {
    id: id,
    type: type
  })

  switch (type) {
    case 'article':
      commit('articles/TOGGLE_BOOKMARK', data.status, { root: true })
      break
    case 'stream':
      commit('streams/TOGGLE_BOOKMARK', data.status, { root: true })
      break
    case 'video':
      commit('videos/TOGGLE_BOOKMARK', data.status, { root: true })
      break
    case 'podcast':
      commit('podcasts/TOGGLE_BOOKMARK', data.status, { root: true })
      break
  }
}

export const getLatestItems = async ({ commit }, pageNumber = 0) => {
  const { data } = await axios.get(`/api/last?page=${pageNumber}`)

  commit(types.GET_LATEST_ITEMS, data)
}

export const getUserBookmarks = async ({ commit }, pageNumber = 0) => {
  const { data } = await axios.get(`/api/bookmark/user?page=${pageNumber}`)

  commit(types.GET_USER_BOOKMARKS, data)
}

export const getBaseStats = async ({ commit }) => {
  const { data } = await axios.get(`/api/stats`)

  commit(types.GET_BASE_STATS, data)
}

export const clearState = async ({ commit }) => {
  commit(types.CLEAR_GLOBAL)
}

export default {
  toggleNav,
  setMobileStatus,
  search,
  toggleBookmarked,
  getLatestItems,
  getUserBookmarks,
  getBaseStats,
  clearState
}
