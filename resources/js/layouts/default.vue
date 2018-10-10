<template>
  <div class="main-layout">
    <w-header/>
    <main>
      <div class="box">
        <child/>
      </div>
    </main>
  </div>
</template>

<script>
import WHeader from '~/components/WHeader'

export default {
  name: 'MainLayout',

  components: {
    WHeader
  }
}
</script>
