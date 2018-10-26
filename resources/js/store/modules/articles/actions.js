import * as types from './mutation-types'
import axios from 'axios'

export const fetchAllArticles = async ({ commit }) => {
  const { data } = await axios.get('/api/articles/all')

  commit(types.FETCH_ALL, data.data)
}

export const fetchById = async ({ commit }, id) => {
  const { data } = await axios.get(`/api/articles/id/${id}`)

  commit(types.FETCH_BY_ID, data.data[0])
}

export const fetchPaginateArticles = async ({ commit }, pageNumber = 1) => {
  const { data } = await axios.get(`/api/articles/paginate?page=${pageNumber}`)

  commit(types.FETCH_PAGINATE, data.data.data)
}

export const clearState = async ({ commit }) => {
  commit(types.CLEAR_ARTICLES)
}

export default {
  fetchAllArticles,
  fetchPaginateArticles,
  clearState,
  fetchById
}
