<template>
  <card :title="$t('register')" :side-image-src="sideImageSRC">
    <form @submit.prevent="register" @keydown="form.onKeydown($event)">
      <!-- Name -->
      <div class="field">
        <label class="label">{{ $t('nickname') }}</label>
        <div class="control has-icons-left">
          <input v-model="form.nickname" :class="{ 'is-danger': form.errors.has('nickname') }" class="input" type="text" name="nickname">
          <span class="icon is-small is-left">
            <fa :icon="'user'" fixed-width/>
          </span>
        </div>
        <p class="help is-danger">
          <has-error :form="form" field="nickname"/>
        </p>
      </div>

      <!-- Email -->
      <div class="field">
        <label class="label">{{ $t('email') }}</label>
        <div class="control has-icons-left has-icons-right">
          <input v-model="form.email" :class="{ 'is-danger': form.errors.has('email') }" class="input" type="email" name="email">
          <span class="icon is-small is-left">
            <fa :icon="'envelope'" fixed-width/>
          </span>
        </div>
        <p class="help is-danger">
          <has-error :form="form" field="email"/>
        </p>
      </div>

      <!-- Password -->
      <div :data-hint="$t('dont_reuse_bank_password')" class="field hint">
        <label class="label">{{ $t('password') }}</label>
        <div class="control has-icons-left has-icons-right">
          <input v-model="form.password" :class="{ 'is-danger': form.errors.has('password') }" class="input" type="password" name="password">
          <span class="icon is-small is-left">
            <fa :icon="'user-lock'" fixed-width/>
          </span>
        </div>
        <p class="help is-danger">
          <has-error :form="form" field="password"/>
        </p>
      </div>

      <!-- Password Confirmation -->
      <div class="field">
        <label class="label">{{ $t('confirm_password') }}</label>
        <div class="control has-icons-left has-icons-right">
          <input v-model="form.password_confirmation" :class="{ 'is-danger': form.errors.has('password_confirmation') }" class="input" type="password" name="password_confirmation">
          <span class="icon is-small is-left">
            <fa :icon="'user-lock'" fixed-width/>
          </span>
        </div>
        <p class="help is-danger">
          <has-error :form="form" field="password_confirmation"/>
        </p>
      </div>

      <button :disabled="form.busy" type="submit" class="button is-link is-medium is-fullwidth is-rounded">{{ $t('register') }}</button>
    </form>
    <p>
      {{ $t('already_have_account') }}?
      <router-link :to="{ name: 'login' }">
        {{ $t('login') }}
      </router-link>
    </p>
  </card>
</template>

<script>
import Form from 'vform'

export default {
  middleware: 'guest',
  metaInfo () {
    return { title: this.$t('register') }
  },

  data: () => ({
    sideImageSRC: '/img/engineering-vector.png',
    form: new Form({
      nickname: '',
      email: '',
      password: '',
      password_confirmation: ''
    })
  }),

  methods: {
    async register () {
      // Register the user.
      const { data } = await this.form.post('/api/register')

      // Log in the user.
      const { data: { token } } = await this.form.post('/api/login')

      // Save the token.
      this.$store.dispatch('auth/saveToken', { token })

      // Update the user.
      await this.$store.dispatch('auth/updateUser', { user: data })

      // Redirect home.
      this.$router.push({ name: 'home' })
    }
  }
}
</script>

<style scoped lang="scss">
  .field.hint {
    position: relative;
    &:before {
      content: attr(data-hint);
      position: absolute;
      top: 50%;
      right: 320px;
      text-align: right;
      color: #FFF;
      font-style: italic;
      font-size: 14px;
      width: 300px;
      transform: rotate(3deg) translateY(-50%);
    }
  }
</style>
