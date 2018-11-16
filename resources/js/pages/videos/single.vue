<template>
  <div v-if="single" class="article">
    <iframe id="ytplayer" :src="youtubeLink" type="text/html" width="1025" height="576.5625"
            frameborder="0" allowfullscreen style="margin-bottom: -10px;"/>
    <h1>{{ single.title }}</h1>
    <div v-if="single !== undefined" class="article--body">
      <p v-for="(item, key) in preparedDescription(single.description)" :key="key">
        {{ item }}
      </p>
    </div>
    <footer v-if="single.channel">
      <div class="article-author">
        <div :style="getBackgroundImage(single)" class="author-logo">
          <img :src="single.channel.image_src" :alt="single.channel.title" style="display: none;">
        </div>
        <div class="article-author-info">
          <router-link :to="{name: 'video.channel', params: { channel: single.channel.slug }}">
            {{ single.channel.title }}
          </router-link>
          <p>{{ single.channel.description }}</p>
        </div>
      </div>
    </footer>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  middleware: 'auth',
  layout: 'inner',
  name: 'VideoSingle',

  components: {},

  metaInfo () {
    return {title: this.single.title === undefined ? 'Video' : this.single.title}
  },

  data: () => ({}),

  computed: {
    youtubeLink () {
      return 'https://www.youtube.com/embed/' + this.single.youtube_id
    },
    ...mapGetters({
      single: 'videos/single'
    })
  },

  created () {
    let video = {
      'channel': this.$route.params.channel,
      'slug': this.$route.params.slug
    }

    this.$store.dispatch('videos/fetchBySlug', video)
  },

  methods: {
    preparedDescription (text) {
      if (text === undefined) {
        return null
      }

      let replacedEntersText = text.replace(new RegExp(/\n\n/, 'g'), '\n')
      return replacedEntersText.match(/(.*?)\n/g)
    },
    getBackgroundImage (video) {
      return `background-image: url("${video.channel.image_src}")`
    }
  }
}
</script>

<style>
  main > .box {
    height: 100%;
    min-height: calc(100vh - 80px);
  }
</style>

<style scoped lang="scss">
@import "../../../sass/vars";

.article {
  margin: 20px 0;
  background: $gradient-default;
  border-radius: 5px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.4);
  overflow: hidden;
  color: #FFF;
  &--image {
    background-size: cover;
    background-position: center;
    width: 100%;
    height: 500px;
  }
  h1 {
    color: #FFF;
    margin: 0;
    padding: 20px;
    background-color: $default-black;
    text-align: center;
  }
  &--body {
    padding: 20px 20px 0;
    &:after {
      content: '';
      display: block;
      width: 100%;
      height: 2px;
      background: linear-gradient(to right, #5E4F8E 0%, #554C86 100%);
    }
    > p {
      margin: 0;
    }
    > a {
      display: block;
      width: 200px;
      margin: 20px auto;
      background: linear-gradient(to right, #9857D4 0%, #6546CC 100%);
      color: #FFF;
      padding: 10px 20px;
      border-radius: 5px;
      font-weight: bold;
      text-align: center;
      &:hover {
        box-shadow: 0 4px 6px rgba(0,0,0,.3);
        animation: animateButton 0.3s linear forwards;
      }
    }
  }
  footer {
    display: flex;
    justify-content: space-between;
    padding: 20px;
    align-items: center;
    & .article-author {
      display: flex;
      width: 100%;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      .author-logo {
        width: 100px;
        height: 100px;
        background: #FFF;
        background-size: 85%;
        background-position: center;
        background-repeat: no-repeat;
        margin-bottom: 20px;
      }
      .article-author-info {
        width: 100%;
        text-align: center;
        a {
          font-weight: bold;
          color: $pink;
          &:hover {
            color: $blue;
          }
        }
      }
    }
  }
}
</style>
