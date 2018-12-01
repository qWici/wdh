<template>
  <div class="results__group" v-if="data && data.length > 0">
    <p>{{ title }}</p>
    <router-link v-for="(item, key) in data" :key="key" :to="itemLink(type, item)">
      <span v-html="resultTitle(item.title)" />
    </router-link>
  </div>
</template>

<script>
export default {
  name: 'SearchResultsGroup',

  props: {
    data: { type: Array, default: null, required: true },
    title: { type: String, required: true },
    type: { type: String, required: true },
    query: { type: String, required: true }
  },

  methods: {
    itemLink: function (type, item) {
      if (type === undefined) { return false }

      if (type === 'article') {
        return { name: 'article.single', params: { author: item.author.slug, slug: item.slug } }
      }
      if (type === 'video') {
        return { name: 'video.single', params: { channel: item.channel.slug, slug: item.slug } }
      }
      if (type === 'podcast') {
        return { name: 'podcast.single', params: { show: item.show.slug, slug: item.slug } }
      }
      return { name: 'stream.single', params: { id: item.twitch } }
    },
    resultTitle (title) {
      const queryPosition = title.indexOf(this.query) === -1
        ? title.indexOf((this.query.toLowerCase())) === -1
          ? title.indexOf((this.query.toUpperCase()))
          : title.indexOf((this.query.toLowerCase()))
        : title.indexOf(this.query)

      console.log(title)
      console.log(this.query)

      const queryLength = this.query.length
      const firstPart = title.substr(0, queryPosition)
      const lastPart = title.substr(queryPosition + queryLength, title.length)
      const queryIntoTitle = title.substr(queryPosition, queryLength)

      return `${firstPart}<strong>${queryIntoTitle}</strong>${lastPart}`
    }
  }
}
</script>

<style lang="scss">
@import "../../sass/vars";

.results__group {
    display: flex;
    flex-direction: column;
    p {
        margin-top: 0;
        padding: 10px 15px;
        color: $orange;
        font-size: 14px;
        line-height: 22px;
        font-weight: bold;
    }
    a {
        color: #cacaca;
        line-height: 22px;
        font-size: 14px;
        padding: 11px 15px;
        span strong {
            color: #efa200;
        }
        &:hover {
            color: $orange;
        }
    }
}
</style>
