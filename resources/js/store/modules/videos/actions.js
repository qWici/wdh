import * as types from './mutation-types'
import axios from 'axios'

export const fetchBySlug = async ({ commit }, { channel, slug }) => {
  const { data } = await axios.get(`/api/videos/${channel}/${slug}`)

  commit(types.FETCH_BY_SLUG, data.data[0])
}

export const fetchByChannelSlug = async ({ commit }, { channel, pageNumber = 1 }) => {
  const { data } = await axios.get(`/api/videos/${channel}?page=${pageNumber}`)

  commit(types.FETCH_BY_CHANNEL_SLUG, data.data)
}

export const fetchPaginateVideos = async ({ commit }, pageNumber = 1) => {
  const { data } = await axios.get(`/api/videos/paginate?page=${pageNumber}`)
  const videos = data.data.data

  let currentIndex = videos.length
  let temporaryValue, randomIndex

  while (currentIndex !== 0) {
    randomIndex = Math.floor(Math.random() * currentIndex)
    currentIndex -= 1

    // And swap it with the current element.
    temporaryValue = videos[currentIndex]
    videos[currentIndex] = videos[randomIndex]
    videos[randomIndex] = temporaryValue
  }

  commit(types.FETCH_PAGINATE, videos)
}

export const clearState = async ({ commit }) => {
  commit(types.CLEAR_VIDEOS)
}

export default {
  fetchBySlug,
  fetchPaginateVideos,
  fetchByChannelSlug,
  clearState
}
