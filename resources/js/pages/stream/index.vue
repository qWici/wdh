<template>
  <Transition name="fade" mode="out-in">
    <RouterView />
  </Transition>
</template>

<script>
export default {
  middleware: 'auth',
  layout: 'inner',
  name: 'StreamIndex'
}
</script>
