<template>
  <div class="bookmark" :title="actionTitle" @click="toggleBookmarked">
    <fa :icon="[actionIconType, 'bookmark']" fixed-width />
  </div>
</template>

<script>
export default {
  name: 'Bookmark',

  props: {
    bookmarked: { type: Boolean, default: false, required: true },
    id: { type: Number, default: 0, required: true },
    type: {
      type: String,
      default: null,
      required: true,
      validator: value => {
        return ['article', 'stream', 'video', 'podcast'].indexOf(value) !== -1
      }
    }
  },

  computed: {
    actionTitle () {
      return this.bookmarked ? 'Remove from bookmark' : 'Add to bookmark'
    },
    actionIconType () {
      return this.bookmarked ? 'fas' : 'far'
    }
  },

  methods: {
    toggleBookmarked () {
      this.$store.dispatch('global/toggleBookmarked', { id: this.id, type: this.type })
    }
  }
}
</script>

<style scoped lang="scss">
.bookmark {
    position: absolute;
    top: 0;
    right: -50px;
    width: 50px;
    height: 50px;
    background: #1c1b3c;
    z-index: 2;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 0 10px 10px 0;
    &:hover {
        background: #3a8dff;
        cursor: pointer;
    }
    svg path {
      fill: #FFF;
    }
}

@media only screen and (max-width: 768px) {
  .bookmark {
    top: 0;
    right: 0;
    border-radius: 0 0 0 10px;
    background: #3a8dff;
  }
}
</style>
