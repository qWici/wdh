<template>
  <Transition name="page" mode="out-in">
    <slot>
      <RouterView />
    </slot>
  </Transition>
</template>

<script>
export default {
  name: 'Child'
}
</script>
