<template>
  <div class="main-layout">
    <WHeader />
    <main>
      <Child />
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
