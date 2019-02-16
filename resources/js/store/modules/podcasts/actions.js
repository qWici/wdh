import * as types from './mutation-types'
import axios from 'axios'

export const fetchBySlug = async ({ commit }, { show, slug }) => {
  const { data } = await axios.get(`/api/podcasts/${show}/${slug}`)

  commit(types.FETCH_BY_SLUG, data)
}

export const fetchByShowSlug = async ({ commit }, { show, pageNumber = 1 }) => {
  const { data } = await axios.get(`/api/podcasts/${show}?page=${pageNumber}`)

  commit(types.FETCH_BY_SHOW_SLUG, data.data)
}

export const fetchPaginatePodcasts = async ({ commit }, pageNumber = 1) => {
  const { data } = await axios.get(`/api/podcasts/paginate?page=${pageNumber}`)

  commit(types.FETCH_PAGINATE, data.data)
}

export const clearState = async ({ commit }) => {
  commit(types.CLEAR_PODCASTS)
}

export default {
  fetchBySlug,
  fetchPaginatePodcasts,
  fetchByShowSlug,
  clearState
}
