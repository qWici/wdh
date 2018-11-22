<template>
  <div class="first-section">
    <div class="information">
      <img src="/img/mockup.webp" alt="WebDevHub main page">
      <div class="main-texts">
        <h1>{{ $t('follow_everything') }}</h1>
        <span>{{ $t('faster_easier') }}</span>
      </div>
    </div>
    <footer>
      <div class="text">
        <h3>{{ $t('reg_early_access') }}</h3>
        <p>{{ $t('contact_about_access') }}</p>
      </div>
      <form @submit.prevent="send" @keydown="form.onKeydown($event)">

        <!-- Email -->
        <div class="field">
          <div class="control has-icons-left has-icons-right">
            <input v-model="form.email" :class="{ 'is-danger': form.errors.has('email') }" :placeholder="$t('your_email')" class="input" type="email" name="email">
            <span class="icon is-small is-left">
              <fa :icon="'envelope'" fixed-width />
            </span>
          </div>
          <p class="help is-danger">
            <has-error :form="form" field="email" />
          </p>
        </div>

        <!-- Submit Button -->
        <button :disabled="form.busy" type="submit" class="button is-link is-medium is-fullwidth">{{ $t('get_access') }}</button>
      </form>
    </footer>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import Form from 'vform'
import swal from 'sweetalert2'
import i18n from '~/plugins/i18n'

export default {
  data: () => ({
    status: '',
    form: new Form({
      email: ''
    })
  }),

  computed: mapGetters({
    user: 'auth/user'
  }),

  methods: {
    async send () {
      const { data } = await this.form.post('/api/early-access')

      swal({
        type: data.type,
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

<style scoped lang="scss">
.first-section {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: calc(100vh - 81px);
    .information {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: calc(100% - 200px);
        img {
            height: 300px;
        }
        .main-texts {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            text-align: center;
            h1 {
                color: #FFF;
                font-weight: bold;
                font-size: 36px;
            }
            span {
                font-size: 32px;
                color: #9a9a9a;
            }
        }
    }
    footer {
        background: linear-gradient(135deg, #2677cc 0%, #226ac7 100%);
        height: 200px;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(0,0,0,.3);
        margin-bottom: 40px;
        display: flex;
        justify-content: space-around;
        align-items: flex-start;
        padding-top: 50px;
        .text {
            line-height: 1;
        }
        h3 {
            color: #FFF;
            font-weight: bold;
            margin-top: 0;
        }
        p {
            color: #FFF;
        }
        button {
            background: #33CC33;
            &:hover {
                box-shadow: 0 0 30px #33CC33;
            }
        }
    }
}

@media only screen and (max-width: 768px) {
  .first-section {
    .information {
      height: calc(100% - 270px);
    }
    footer {
      flex-wrap: wrap;
      height: auto;
      text-align: center;
      justify-content: space-between;
      flex-direction: column;
      align-items: center;
      padding: 20px;
      .text {
        margin-bottom: 30px;
      }
      h3 {
        font-size: 29px;
      }
    }
  }
}
</style>
