<template>
  <div class="box">
    <Card :title="$t('register')" :image="side_image_src">
      <form @submit.prevent="register" @keydown="form.onKeydown($event)">
        <!-- Name -->
        <div class="field">
          <label class="label">
            {{ $t('nickname') }}
          </label>
          <div class="control has-icons-left">
            <input v-model="form.nickname" :class="{ 'is-danger': form.errors.has('nickname') }" class="input" type="text" name="nickname">
            <span class="icon is-small is-left">
              <fa :icon="'user'" fixed-width />
            </span>
          </div>
          <p class="help is-danger">
            <has-error :form="form" field="nickname" />
          </p>
        </div>

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
        <div :data-hint="$t('dont_reuse_bank_password')" class="field hint">
          <label class="label">
            {{ $t('password') }}
          </label>
          <div class="control has-icons-left has-icons-right">
            <input v-model="form.password" :class="{ 'is-danger': form.errors.has('password') }" class="input" type="password" name="password" autocomplete="new-password">
            <span class="icon is-small is-left">
              <fa :icon="'user-lock'" fixed-width />
            </span>
          </div>
          <p class="help is-danger">
            <has-error :form="form" field="password" />
          </p>
        </div>

        <!-- Password Confirmation -->
        <div class="field">
          <label class="label">
            {{ $t('confirm_password') }}
          </label>
          <div class="control has-icons-left has-icons-right">
            <input v-model="form.password_confirmation" :class="{ 'is-danger': form.errors.has('password_confirmation') }" class="input" type="password" name="password_confirmation" autocomplete="new-password">
            <span class="icon is-small is-left">
              <fa :icon="'user-lock'" fixed-width />
            </span>
          </div>
          <p class="help is-danger">
            <has-error :form="form" field="password_confirmation" />
          </p>
        </div>

        <p>
          {{ $t('aggrement') }} <br>
          <router-link :to="{ name: 'terms-and-conditions' }" target="_blank">
            {{ $t('terms_conditions') }}
          </router-link>
          {{ $t('and') }}
          <router-link :to="{ name: 'privacy-policy' }" target="_blank">
            {{ $t('privacy_policy') }}
          </router-link>
        </p>

        <button :disabled="form.busy" type="submit" class="button is-link is-medium is-fullwidth is-rounded">
          {{ $t('register') }}
        </button>
      </form>

      <p>
        <LoginWithGithub />
      </p>

      <p>
        {{ $t('already_have_account') }}?
        <router-link :to="{ name: 'login' }">
          {{ $t('login') }}
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
  metaInfo () {
    return { title: this.$t('register') }
  },

  components: {
    LoginWithGithub
  },

  data: () => ({
    side_image_src: '/img/engineering-vector.png',
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
form p {
  color: #FFF;
  text-align: center;
  a {
    color: #FD7FB6;
  }
}
.field.hint {
  position: relative;
  &:before {
    content: attr(data-hint);
    position: absolute;
    top: 50%;
    left: 320px;
    text-align: right;
    color: #FFF;
    font-style: italic;
    font-size: 14px;
    width: 300px;
    transform: rotate(-3deg) translateY(-50%);
  }
}

@media only screen and (max-width: 768px) {
  .field.hint:before {
    display: none;
  }
}
</style>
