import * as types from './mutation-types'
import axios from 'axios'

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
  fetchPaginateVideos,
  clearState
}
