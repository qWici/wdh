import * as types from './mutation-types'

export const setBreadcrumbs = ({ commit }, payload) => {
  commit(types.SET_BREADCRUMBS, payload)
}

export default {
  setBreadcrumbs
}
