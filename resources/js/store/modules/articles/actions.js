import * as types from './mutation-types'
import axios from 'axios'

export const fetchAllArticles = async ({ commit }) => {
  const { data } = await axios.get('/api/articles/all')

  commit(types.FETCH_ALL, data.data)
}

export const fetchBySlug = async ({ commit }, { author, slug }) => {
  const { data } = await axios.get(`/api/articles/${author}/${slug}`)

  commit(types.FETCH_BY_SLUG, data.data[0])
}

export const fetchPaginateArticles = async ({ commit }, pageNumber = 1) => {
  const { data } = await axios.get(`/api/articles/paginate?page=${pageNumber}`)
  const articles = data.data.data

  let currentIndex = articles.length
  let temporaryValue, randomIndex

  while (currentIndex !== 0) {
    randomIndex = Math.floor(Math.random() * currentIndex)
    currentIndex -= 1

    // And swap it with the current element.
    temporaryValue = articles[currentIndex]
    articles[currentIndex] = articles[randomIndex]
    articles[randomIndex] = temporaryValue
  }

  commit(types.FETCH_PAGINATE, articles)
}

export const clearState = async ({ commit }) => {
  commit(types.CLEAR_ARTICLES)
}

export default {
  fetchAllArticles,
  fetchPaginateArticles,
  clearState,
  fetchBySlug
}
