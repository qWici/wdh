import * as types from './mutation-types'
import axios from 'axios'

export const fetchBySlug = async ({ commit }, { channel, slug }) => {
  const { data } = await axios.get(`/api/videos/${channel}/${slug}`)

  commit(types.FETCH_BY_SLUG, data)
}

export const fetchByChannelSlug = async ({ commit }, { channel, pageNumber = 1 }) => {
  const { data } = await axios.get(`/api/videos/${channel}?page=${pageNumber}`)

  commit(types.FETCH_BY_CHANNEL_SLUG, data.data)
}

export const fetchPaginateVideos = async ({ commit }, pageNumber = 1) => {
  const { data } = await axios.get(`/api/videos/paginate?page=${pageNumber}`)

  commit(types.FETCH_PAGINATE, data.data)
}

export const fetchChannels = async ({ commit }) => {
  const { data } = await axios.get(`/api/channels`)

  commit(types.FETCH_CHANNELS, data)
}

export const clearState = async ({ commit }) => {
  commit(types.CLEAR_VIDEOS)
}

export default {
  fetchBySlug,
  fetchPaginateVideos,
  fetchByChannelSlug,
  fetchChannels,
  clearState
}
