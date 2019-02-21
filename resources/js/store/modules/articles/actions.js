import * as types from './mutation-types'
import axios from 'axios'

export const fetchAllArticles = async ({ commit }) => {
  const { data } = await axios.get('/api/articles/all')

  commit(types.FETCH_ALL, data)
}

export const fetchByAuthorSlug = async ({ commit }, { author, pageNumber = 1 }) => {
  const { data } = await axios.get(`/api/articles/${author}?page=${pageNumber}`)

  commit(types.FETCH_BY_AUTHOR_SLUG, data.data)
}

export const fetchBySlug = async ({ commit }, { author, slug }) => {
  const { data } = await axios.get(`/api/articles/${author}/${slug}`)

  commit(types.FETCH_BY_SLUG, data)
}

export const fetchPaginateArticles = async ({ commit }, pageNumber = 1, filters = []) => {
  const filtersToString = Object.keys(filters).map(key => key + '=' + filters[key]).join('&')
  const requestURL = filtersToString.length > 0
    ? `/api/articles/paginate?page=${pageNumber}&filters=${filtersToString}`
    : `/api/articles/paginate?page=${pageNumber}`

  const { data } = await axios.get(requestURL)

  commit(types.FETCH_PAGINATE, data.data)
}

export const clearState = async ({ commit }) => {
  commit(types.CLEAR_ARTICLES)
}

export default {
  fetchAllArticles,
  fetchPaginateArticles,
  clearState,
  fetchByAuthorSlug,
  fetchBySlug
}
