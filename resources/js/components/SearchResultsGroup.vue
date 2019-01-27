<template>
  <div class="results__group" v-if="data && data.length > 0">
    <p>{{ title }}</p>
    <router-link v-for="(item, key) in data" :key="key" :to="itemLink(type, item)">
      <div class="result--item-img" :style="generateImageStyle(item, type)" />
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
      const queryLower = this.query.toLowerCase()
      const titleLower = title.toLowerCase()
      const queryPosInTitle = titleLower.indexOf(queryLower)

      if (queryPosInTitle === 0) {
        const queryIntoTitle = title.substr(0, queryLower.length)
        const lastPart = title.substr(queryLower.length, title.length)

        return `<strong>${queryIntoTitle}</strong>${lastPart}`
      }

      const firstPart = title.substr(0, queryPosInTitle)
      const queryIntoTitle = title.substr(firstPart.length, queryLower.length)
      const lengthSum = firstPart.length + queryIntoTitle.length
      const lastPart = title.substr(lengthSum, (title.length - lengthSum))

      return `${firstPart}<strong>${queryIntoTitle}</strong>${lastPart}`
    },
    generateImageStyle (item, type) {
      const imagePath = this.getItemImage(item, type)
      return `background-image: url('${imagePath}')`
    },
    getItemImage (item, type) {
      if (type === 'podcast') {
        return item.show.image_url
      }

      return item.image_src
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
    &:last-child {
      a:last-child:hover {
        border-radius: 0 0 5px 5px;
      }
    }
    a {
        color: #cacaca;
        line-height: 22px;
        font-size: 14px;
        padding: 11px 15px;
        display: flex;
        align-items: center;
        /*&:nth-child(odd) {*/
          /*background-color: #343561;*/
        /*}*/
        .result--item-img {
          min-width: 50px;
          height: 30px;
          background-size: cover;
          background-position: center;
          margin-right: 20px;
        }
        span strong {
            color: #efa200;
        }
        &:hover {
            color: $orange;
            background: linear-gradient(45deg, #312b54 0%, #191d3b 100%)
        }
    }
}
</style>
