<template>
  <div class="box">
    <Card :title="$t('login')" :image="side_image_src">
      <form @submit.prevent="login" @keydown="form.onKeydown($event)">
        <!-- Email -->
        <div class="field">
          <label class="label">
            {{ $t('email') }}
          </label>
          <div class="control has-icons-left has-icons-right">
            <input v-model="form.email" :class="{ 'is-danger': form.errors.has('email') }" class="input" type="email" name="email" autocomplete="username">
            <span class="icon is-small is-left">
              <fa :icon="'envelope'" fixed-width />
            </span>
          </div>
          <p class="help is-danger">
            <has-error :form="form" field="email" />
          </p>
        </div>

        <!-- Password -->
        <div class="field">
          <label class="label">
            {{ $t('password') }}
          </label>
          <div class="control has-icons-left has-icons-right">
            <input v-model="form.password" :class="{ 'is-danger': form.errors.has('password') }" class="input" type="password" name="password" autocomplete="current-password">
            <span class="icon is-small is-left">
              <fa :icon="'user-lock'" fixed-width />
            </span>
          </div>
          <p class="help is-danger">
            <has-error :form="form" field="password" />
          </p>
        </div>

        <!-- Remember Me -->
        <div class="field-details">
          <Checkbox v-model="remember" name="remember">
            {{ $t('remember_me') }}
          </Checkbox>
        </div>

        <button :disabled="form.busy" type="submit" class="button is-link is-medium is-fullwidth is-rounded">
          {{ $t('login') }}
        </button>
      </form>

      <p>
        <LoginWithGithub />
      </p>

      <p>
        {{ $t('dont_have_account') }}?
        <router-link :to="{ name: 'register' }">
          {{ $t('register') }}
        </router-link>
      </p>
      <p>
        <router-link :to="{ name: 'password.request' }">
          {{ $t('forgot_password') }}
        </router-link>
      </p>
    </Card>
  </div>
  <!-- /.box -->
</template>

<script>
import Form from 'vform'
import LoginWithGithub from '~/components/LoginWithGithub'

export default {
  middleware: 'guest',

  components: {
    LoginWithGithub
  },

  metaInfo () {
    return { title: this.$t('login') }
  },

  data: () => ({
    side_image_src: '/img/software-engineers-vector.png',
    form: new Form({
      email: '',
      password: ''
    }),
    remember: false
  }),

  methods: {
    async login () {
      // Submit the form.
      const { data } = await this.form.post('/api/login')

      // Save the token.
      this.$store.dispatch('auth/saveToken', {
        token: data.token,
        remember: this.remember
      })

      // Fetch the user.
      await this.$store.dispatch('auth/fetchUser')

      // Redirect home.
      this.$router.push({ name: 'home' })
    }
  }
}
</script>
