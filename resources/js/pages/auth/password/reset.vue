<template>
  <Card :title="$t('reset_password')" :side_image_src="side_image_src">
    <form @submit.prevent="reset" @keydown="form.onKeydown($event)">
      <!-- Email -->
      <div class="field">
        <label class="label">
          {{ $t('email') }}
        </label>
        <div class="control has-icons-left has-icons-right">
          <input v-model="form.email" :class="{ 'is-danger': form.errors.has('email') }" class="input" type="email" name="email">
          <span class="icon is-small is-left">
            <Fa :icon="'envelope'" fixed-width />
          </span>
        </div>
        <p class="help is-danger">
          <HasError :form="form" field="email" />
        </p>
      </div>

      <!-- Password -->
      <div :data-hint="$t('dont_reuse_bank_password')" class="field hint">
        <label class="label">
          {{ $t('password') }}
        </label>
        <div class="control has-icons-left has-icons-right">
          <input v-model="form.password" :class="{ 'is-danger': form.errors.has('password') }" class="input" type="password" name="password">
          <span class="icon is-small is-left">
            <Fa :icon="'user-lock'" fixed-width />
          </span>
        </div>
        <p class="help is-danger">
          <HasError :form="form" field="password" />
        </p>
      </div>

      <!-- Password Confirmation -->
      <div class="field">
        <label class="label">
          {{ $t('confirm_password') }}
        </label>
        <div class="control has-icons-left has-icons-right">
          <input v-model="form.password_confirmation" :class="{ 'is-danger': form.errors.has('password_confirmation') }" class="input" type="password" name="password_confirmation">
          <span class="icon is-small is-left">
            <Fa :icon="'user-lock'" fixed-width />
          </span>
        </div>
        <p class="help is-danger">
          <HasError :form="form" field="password_confirmation" />
        </p>
      </div>

      <!-- Submit Button -->
      <button :disabled="form.busy" type="submit" class="button is-link is-medium is-fullwidth is-rounded">
        {{ $t('reset_password') }}
      </button>
    </form>
  </Card>
</template>

<script>
import Form from 'vform'
import swal from 'sweetalert2'
import i18n from '~/plugins/i18n'

export default {
  middleware: 'guest',

  metaInfo () {
    return { title: this.$t('reset_password') }
  },

  data: () => ({
    side_image_src: '/img/wolverine-reset-password.png',
    form: new Form({
      token: '',
      email: '',
      password: '',
      password_confirmation: ''
    })
  }),

  created () {
    this.form.email = this.$route.query.email
    this.form.token = this.$route.params.token
  },

  methods: {
    async reset () {
      const { data } = await this.form.post('/api/password/reset')

      swal({
        type: 'success',
        title: i18n.t('info_updated'),
        text: data.status,
        reverseButtons: true,
        confirmButtonText: i18n.t('ok'),
        cancelButtonText: i18n.t('cancel')
      })

      this.form.reset()
    }
  }
}
</script>
