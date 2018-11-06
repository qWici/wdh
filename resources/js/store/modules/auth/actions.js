import * as types from './mutation-types'
import axios from 'axios'

export const saveToken = ({ commit, dispatch }, payload) => {
  commit(types.SAVE_TOKEN, payload)
}

export const fetchUser = async ({ commit }) => {
  try {
    const { data } = await axios.get('/api/user')

    commit(types.FETCH_USER_SUCCESS, { user: data })
  } catch (e) {
    commit(types.FETCH_USER_FAILURE)
  }
}

export const updateUser = ({ commit }, payload) => {
  commit(types.UPDATE_USER, payload)
}

export const updateUserPhoto = async ({ commit }, file) => {
  const { data } = await axios.post('/api/settings/profile/photo', file)

  commit(types.UPDATE_USER_PHOTO, data)
}

export const logout = async ({ commit }) => {
  try {
    await axios.post('/api/logout')
  } catch (e) { }

  commit(types.LOGOUT)
}

export const fetchOauthUrl = async (ctx, { provider }) => {
  const { data } = await axios.post(`/api/oauth/${provider}`)

  return data.url
}

export default {
  saveToken,
  fetchUser,
  updateUser,
  logout,
  fetchOauthUrl,
  updateUserPhoto
}
