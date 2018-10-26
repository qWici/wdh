import * as types from './mutation-types'
import axios from 'axios'

export const fetchAllArticles = async ({ commit }) => {
  const { data } = await axios.get('/api/articles/all')

  commit(types.FETCH_ALL, data.data)
}

export const fetchPaginateArticles = async ({ commit }, pageNumber = 1) => {
  const { data } = await axios.get(`/api/articles/paginate?page=${pageNumber}`)

  commit(types.FETCH_PAGINATE, data.data.data)
}

export default {
  fetchAllArticles,
  fetchPaginateArticles
}
