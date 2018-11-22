<template>
  <div class="main-layout">
    <w-header />
    <main>
      <div class="box">
        <w-sidebar />
        <div class="content left-sidebar">
          <w-breadcrumbs />
          <child />
        </div>
      </div>
    </main>
  </div>
</template>

<script>
import WHeader from '~/components/WHeader'
import WSidebar from '~/components/WSidebar'
import WBreadcrumbs from '~/components/WBreadcrumbs'

export default {
  name: 'InnerLayout',

  components: {
    WHeader,
    WSidebar,
    WBreadcrumbs
  }
}
</script>
