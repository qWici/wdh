import * as types from './mutation-types'
import axios from 'axios'

export const fetchBySlug = async ({ commit }, { show, slug }) => {
  const { data } = await axios.get(`/api/podcasts/${show}/${slug}`)

  commit(types.FETCH_BY_SLUG, data.data[0])
}

export const fetchByShowSlug = async ({ commit }, { show, pageNumber = 1 }) => {
  const { data } = await axios.get(`/api/podcasts/${show}?page=${pageNumber}`)

  commit(types.FETCH_BY_SHOW_SLUG, data.data)
}

export const fetchPaginatePodcasts = async ({ commit }, pageNumber = 1) => {
  const { data } = await axios.get(`/api/podcasts/paginate?page=${pageNumber}`)
  const podcasts = data.data.data

  let currentIndex = podcasts.length
  let temporaryValue, randomIndex

  while (currentIndex !== 0) {
    randomIndex = Math.floor(Math.random() * currentIndex)
    currentIndex -= 1

    // And swap it with the current element.
    temporaryValue = podcasts[currentIndex]
    podcasts[currentIndex] = podcasts[randomIndex]
    podcasts[randomIndex] = temporaryValue
  }

  commit(types.FETCH_PAGINATE, podcasts)
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
