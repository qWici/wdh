<template>
  <transition name="fade" mode="out-in">
    <router-view />
  </transition>
</template>

<script>
export default {
  layout: 'inner',
  name: 'StreamIndex'
}
</script>
