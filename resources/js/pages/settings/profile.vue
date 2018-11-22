<template>
  <form @submit.prevent="update" @keydown="form.onKeydown($event)">
    <h2>{{ $t('your_info') }}</h2>
    {{ form.successful ? success() : null }}

    <!-- Photo -->
    <div class="user-photo">
      <img :src="userPhoto" :alt="user.nickname">
      <input id="image_src" type="file" name="image_src" @change="updatePhoto($event)">
      <label for="image_src">
        <fa :icon="['fas', 'upload']" fixed-width />
      </label>
    </div>

    <!-- Nickname -->
    <div class="field">
      <label class="label">{{ $t('nickname') }}</label>
      <div class="control">
        <input v-model="form.nickname" :class="{ 'is-danger': form.errors.has('nickname') }" class="input" type="text" name="nickname">
        <has-error :form="form" field="nickname" />
      </div>
    </div>

    <!-- Specialization -->
    <div class="field">
      <label class="label">{{ $t('position') }}</label>
      <div class="control">
        <input v-model="form.specialization" :class="{ 'is-danger': form.errors.has('specialization') }" class="input" type="text" name="specialization">
        <has-error :form="form" field="specialization" />
      </div>
    </div>

    <!-- Email -->
    <div class="field">
      <label class="label">{{ $t('email') }}</label>
      <div class="control">
        <input v-model="form.email" :class="{ 'is-danger': form.errors.has('email') }" class="input" type="email" name="email">
        <has-error :form="form" field="email" />
      </div>
    </div>

    <!-- Submit Button -->
    <v-button :loading="form.busy" class="button is-link is-medium is-rounded" type="success">{{ $t('update') }}</v-button>
  </form>
</template>

<script>
import Form from 'vform'
import swal from 'sweetalert2'
import { mapGetters } from 'vuex'

export default {
  scrollToTop: false,

  metaInfo () {
    return { title: this.$t('settings') }
  },

  data: () => ({
    form: new Form({
      nickname: '',
      email: '',
      specialization: ''
    })
  }),

  computed: mapGetters({
    user: 'auth/user',
    userPhoto: 'auth/userPhoto'
  }),

  created () {
    this.form.keys().forEach(key => {
      this.form[key] = this.user[key]
    })
  },

  methods: {
    async update () {
      const { data } = await this.form.patch('/api/settings/profile')

      this.$store.dispatch('auth/updateUser', data)
    },
    updatePhoto (event) {
      let file = event.target.files[0]
      let data = new FormData()
      data.append('userPhoto', file)

      this.$store.dispatch('auth/updateUserPhoto', data)
    },
    success () {
      swal({
        type: 'success',
        title: this.$t('info_updated')
      })

      this.form.successful = false
    }
  }
}
</script>

<style scoped lang="scss">
  form {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding-bottom: 20px;
    h2 {
      margin: 20px 0 20px;
      font-weight: bold;
      color: #FFF;
      font-size: 24px;
    }
    label {
      color: #3c81e8;
    }
    button {
      margin-top: 20px;
      background: linear-gradient(to bottom, #396afc 0%, #2948ff 100%);
    }
    .user-photo {
      position: relative;
      overflow: hidden;
      border-radius: 50%;
      &:hover {
        cursor: pointer;
        > label {
          display: block
        }
      }
      & input[type=file] {
        display: none;
      }
      & label {
        display: none;
        position: absolute;
        top: 0;
        left: 0;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        margin: 0;
        background-color: rgba(0,0,0,0.5);
        &:hover {
          cursor: pointer;
        }
        & svg {
          font-size: 32px;
          color: #FFF;
          position: absolute;
          top: 50%;
          left: 50%;
          transform: translate(-50%, -50%);
        }
      }
      & img {
        border-radius: 50%;
        width: 200px;
        height: 200px;
      }
    }
  }
</style>
