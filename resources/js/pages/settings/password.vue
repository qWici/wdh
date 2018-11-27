<template>
  <form @submit.prevent="update" @keydown="form.onKeydown($event)">
    <h2>{{ $t('your_password') }}</h2>
    {{ form.successful ? success() : null }}

    <!-- Password -->
    <div class="field">
      <label class="label">
        {{ $t('new_password') }}
      </label>
      <div class="control">
        <input v-model="form.password" :class="{ 'is-danger': form.errors.has('password') }" class="input" type="password" name="password">
        <has-error :form="form" field="password" />
      </div>
    </div>

    <!-- Password Confirmation -->
    <div class="field">
      <label class="label">
        {{ $t('confirm_password') }}
      </label>
      <div class="control">
        <input v-model="form.password_confirmation" :class="{ 'is-danger': form.errors.has('password_confirmation') }" class="input" type="password" name="password_confirmation">
        <has-error :form="form" field="password_confirmation" />
      </div>
    </div>

    <!-- Submit Button -->
    <VButton :loading="form.busy" class="button is-link is-medium is-rounded" type="success">
      {{ $t('update') }}
    </VButton>
  </form>
</template>

<script>
import Form from 'vform'
import swal from 'sweetalert2'

export default {
  scrollToTop: false,

  metaInfo () {
    return { title: this.$t('settings') }
  },

  data: () => ({
    form: new Form({
      password: '',
      password_confirmation: ''
    })
  }),

  methods: {
    async update () {
      await this.form.patch('/api/settings/password')

      this.form.reset()
    },
    success () {
      swal({
        type: 'success',
        title: this.$t('password_updated')
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
