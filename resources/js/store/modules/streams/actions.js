import * as types from './mutation-types'
import axios from 'axios'

export const fetchOnlineStreams = async ({ commit }, pageNumber = 1) => {
  const { data } = await axios.get(`/api/streams/online?page=${pageNumber}`)

  commit(types.FETCH_ONLINE, data.data.data)
}

export const fetchLastOnline = async ({ commit }) => {
  const { data } = await axios.get('/api/streams/lastonline')

  commit(types.FETCH_LAST_ONLINE, data.data)
}

export const fetchStreamTags = async ({ commit }, twitchname) => {
  const { data } = await axios.get(`/api/streams/tags/${twitchname}`)

  commit(types.FETCH_STREAM_TAGS, data.data)
}

export const fetchStreamsByTag = async ({ commit }, tag) => {
  const { data } = await axios.get(`/api/streams/tag/${tag}`)

  commit(types.FETCH_STREAM_BY_TAG, data.data)
}

export const clearState = async ({ commit }) => {
  commit(types.CLEAR_STREAMS)
}

export default {
  fetchOnlineStreams,
  fetchLastOnline,
  fetchStreamTags,
  fetchStreamsByTag,
  clearState
}
