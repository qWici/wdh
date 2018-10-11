<template>
  <form @submit.prevent="send" @keydown="form.onKeydown($event)">
    <div class="wrapper">
      <img src="https://mbtskoudsalg.com/images/rick-y-morty-vector-png-7.png" alt="">
      <h1>{{ $t('reset_password') }}</h1>
      <alert-success :form="form" :message="status"/>

      <!-- Email -->
      <div class="field">
        <label class="label">{{ $t('email') }}</label>
        <div class="control has-icons-left has-icons-right">
          <input v-model="form.email" :class="{ 'is-danger': form.errors.has('email') }" class="input" type="email" name="email" :placeholder="$t('your_email')">
          <span class="icon is-small is-left">
            <fa :icon="'envelope'" fixed-width/>
          </span>
        </div>
        <p class="help is-danger">
          <has-error :form="form" field="email"/>
        </p>
      </div>

      <!-- Submit Button -->
      <button :disabled="form.busy" type="submit" class="button is-link is-medium is-fullwidth">{{ $t('send_password_reset_link') }}</button>
    </div>
  </form>
</template>

<script>
import Form from 'vform'

export default {
  middleware: 'guest',

  metaInfo () {
    return { title: this.$t('reset_password') }
  },

  data: () => ({
    status: '',
    form: new Form({
      email: ''
    })
  }),

  methods: {
    async send () {
      const { data } = await this.form.post('/api/password/email')

      this.status = data.status

      this.form.reset()
    }
  }
}
</script>

<style scoped lang="scss">
form {
  width: 100%;
  display: flex;
  justify-content: center;
  label {
    color: #FD7FB6;
  }
  .wrapper {
    text-align: center;
    img {
      height: 300px;
    }
    h1 {
      margin-top: 0;
      color: #FFF;
      text-transform: uppercase;
      letter-spacing: 2px;
      font-weight: bold;
    }
  }
}
</style>