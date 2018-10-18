import * as types from './mutation-types'
import axios from 'axios'

export const fetchOnlineStreams = async ({ commit }) => {
  const { data } = await axios.get('/api/streams/online')

  commit(types.FETCH_ONLINE, data.data)
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

export default {
  fetchOnlineStreams,
  fetchLastOnline,
  fetchStreamTags,
  fetchStreamsByTag
}
