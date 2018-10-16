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

export default {
  fetchOnlineStreams,
  fetchLastOnline
}
