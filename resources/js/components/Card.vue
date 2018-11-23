<template>
  <div class="wcard">
    <aside v-if="title">
      <div class="cart-title">
        <h1>{{ title }}</h1>
      </div>

      <div class="card-body">
        <slot />
      </div>
    </aside>

    <div class="side-image-block">
      <img :src="image" alt="Register image on WebDevHub.com">
    </div>
  </div>
</template>

<script>
export default {
  name: 'Card',

  props: {
    title: { type: String, default: null },
    image: { type: String, default: null }
  }
}
</script>
