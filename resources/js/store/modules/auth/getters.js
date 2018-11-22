export default {
  user: state => state.user,
  token: state => state.token,
  check: state => state.user !== null,
  userPhoto: state => {
    if (state.user === null) {
      return false
    }
    if (state.user.image_src) {
      if (state.user.image_src.includes('githubusercontent')) {
        return state.user.image_src
      }
      return '/images/users/' + state.user.image_src
    }
    if (state.user.photo_url) {
      return state.user.photo_url
    }
  }
}
