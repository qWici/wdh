<template>
  <div class="main-layout">
    <w-header/>
    <main>
      <div class="box">
        <w-sidebar/>
        <div class="content left-sidebar">
          <child/>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
import WHeader from '~/components/WHeader'
import WSidebar from '~/components/WSidebar'

export default {
  name: 'InnerLayout',

  components: {
    WHeader,
    WSidebar
  }
}
</script>
