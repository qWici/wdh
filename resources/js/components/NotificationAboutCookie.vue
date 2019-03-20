<template>
  <div class="cookie-notification">
    <cookie-law theme="purple" @accept="agree" ref="cookielaw">
      <div slot-scope="props">
        <div class="texts">
          <span>{{ $t('cookie.title') }}</span>
          <p>{{ $t('cookie.message') }}. {{ $t('more') }} <a target="_blank" href="https://www.websitepolicies.com/policies/view/DEp1vxNI">Cookie policy</a></p>
        </div>
        <!-- /.texts -->
        <div class="Cookie-buttons">
          <button class="agree" @click="props.accept">
            {{ $t('cookie.agree') }}
          </button>
          <button class="ignore" @click="props.close">
            {{ $t('cookie.ignore') }}
          </button>
        </div>
        <!-- /.buttons -->
      </div>
    </cookie-law>
  </div>
  <!-- /.cookie-notification -->
</template>

<script>
import CookieLaw from 'vue-cookie-law'

export default {
  name: 'NotificationAboutCookie',
  components: { CookieLaw },
  methods: {
    agree () {
      this.$store.dispatch('global/setCookieAccepted')
    },
    show () {
      this.$refs.cookielaw.open()
    }
  }
}
</script>

<style lang="scss">
  @import '../../sass/elements/cookie-notification';
</style>
