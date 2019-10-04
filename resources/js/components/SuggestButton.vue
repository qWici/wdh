<template>
  <router-link :to="linkRoute" class="suggest-button" :title="linkTitle">
    <div class="suggest-button__icon">
      <fa :icon="'lightbulb'" size="2x" :alt="linkTitle" />
    </div>
    <b>{{ linkTitle }}</b>
  </router-link>
</template>

<script>
export default {
  name: 'SuggestButton',

  props: {
    type: {
      type: String,
      required: true,
      validator: value => {
        return ['author', 'stream', 'channel', 'show'].indexOf(value) !== -1
      }
    }
  },

  computed: {
    linkRoute () {
      return { name: 'suggest.type', params: { type: this.type } }
    },
    linkTitle () {
      switch (this.type) {
        case 'author':
          return this.$t('articles.suggest')
        case 'stream':
          return this.$t('streams.suggest')
        case 'channel':
          return this.$t('videos.suggest')
        default:
          return this.$t('podcasts.suggest')
      }
    }
  }
}
</script>

<style lang="scss" scoped>
.suggest-button {
  border-radius: 5px;
  color: #fff;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  background-color: #5f3651;
  min-height: 150px;
  &:hover {
    background-color: #a05a89;
  }
  &__icon {
    margin-bottom: 15px;
  }
}
</style>
