<template>
  <router-link :to="itemLink" class="content-item" :title="title" :style="'background-image: url(' + src + ')'">
    <lang-flag v-if="lang !== null" :iso="lang" :squared="false" class="flag" />

    <span class="item-info">
      <span class="title">
        {{ title }}
      </span>
    </span>
  </router-link>
</template>

<script>
export default {
  name: 'AuthorItem',

  props: {
    src: { type: String, default: '/img/no_image.webp' },
    title: { type: String, required: true },
    link: { type: [String, Number, Object], required: true },
    lang: { type: String, default: null },
    online: { type: Boolean, default: false },
    type: {
      type: String,
      default: null,
      validator: value => {
        return ['article', 'video', 'podcast'].indexOf(value) !== -1
      }
    }
  },

  computed: {
    itemLink: function () {
      if (this.type === 'article') {
        return { name: 'article.author', params: { author: this.link.author } }
      }
      if (this.type === 'video') {
        return { name: 'video.channel', params: { channel: this.link.channel } }
      }
      if (this.type === 'podcast') {
        return { name: 'podcast.show', params: { show: this.link.show } }
      }

      return { name: 'home' }
    }
  }
}
</script>

<style scoped lang="scss">
@import "../../sass/elements/content-item";
.content-item {
  min-height: 320px;
  background-size: 81%;
  background-repeat: no-repeat;
  background-position: center;
  background-color: #FFF;
  .item-info {
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    background: transparent;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    transition: all .3s;
    &:hover {
      background: linear-gradient(30deg, rgba(22,191,253,0.95), rgba(203,48,102,0.95));
      transition: all .3s;
      span.title {
        color: #FFF;
        transition: all .3s;
      }
    }
    span {
      &.title {
        margin: 0;
        font-size: 22px;
        max-height: fit-content;
        color: transparent;
        transition: all .3s;
        text-align: center;
      }
    }
  }
}
</style>
