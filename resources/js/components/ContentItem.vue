<template>
  <router-link :to="itemLink" class="content-item" :title="title">
    <lang-flag v-if="lang !== null" :iso="lang" :squared="false" class="flag" />

    <div v-if="stream" :class="online ? 'live' : 'offline'" class="status">
      {{ status }}
    </div>

    <div :style="'background-image: url(' + src + ')'" class="img-wrapper">
      <img :src="src" :alt="title" style="display: none">
    </div>

    <span class="item-info">
      <span class="title">
        {{ title }}
      </span>
      <span class="data">
        <span v-if="stream" class="date">
          {{ date }}
        </span>
        <span class="author">
          {{ author }}
        </span>
      </span>
    </span>
  </router-link>
</template>

<script>
export default {
  name: 'ContentItem',

  props: {
    src: { type: String, default: '/img/no_image.webp' },
    title: { type: String, required: true },
    link: { type: [String, Number, Object], required: true },
    author: { type: String, required: true },
    date: { type: String, default: null },
    lang: { type: String, default: null },
    online: { type: Boolean, default: false },
    type: {
      type: String,
      default: null,
      validator: value => {
        return ['article', 'stream', 'video', 'podcast'].indexOf(value) !== -1
      }
    }
  },

  computed: {
    stream: function () {
      return this.type === 'stream'
    },
    status: function () {
      return this.online ? this.$t('live') : this.$t('offline')
    },
    itemLink: function () {
      if (this.type === 'article') {
        return { name: 'article.single', params: { author: this.link.author, slug: this.link.slug } }
      }
      if (this.type === 'video') {
        return { name: 'video.single', params: { channel: this.link.channel, slug: this.link.slug } }
      }
      if (this.type === 'podcast') {
        return { name: 'podcast.single', params: { show: this.link.show, slug: this.link.slug } }
      }
      return { name: 'stream.single', params: { id: this.link } }
    }
  }
}
</script>

<style scoped lang="scss">
@import "../../sass/elements/content-item";
</style>
