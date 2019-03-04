<template>
  <div class="cookie-notification">
    <cookie-law theme="purple">
      <div slot-scope="props">
        <div class="texts">
          <span>{{ $t('cookie.title') }}</span>
          <p>{{ $t('cookie.message') }}</p>
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
  components: { CookieLaw }
}
</script>

<style lang="scss">
  @import '../../sass/elements/cookie-notification';
</style>
