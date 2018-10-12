<template>
  <div class="test">
    test
  </div>
</template>

<script>
export default {
  middleware: 'auth',
  layout: 'inner',

  metaInfo () {
    return { title: this.$t('home') }
  }
}
</script>
