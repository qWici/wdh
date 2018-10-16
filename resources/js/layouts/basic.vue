<template>
  <div class="main-layout">
    <w-header/>
    <main>
      <child/>
    </main>
  </div>
</template>

<script>
import WHeader from '~/components/WHeader'

export default {
  name: 'BasicLayout',

  components: {
    WHeader
  }
}
</script>
