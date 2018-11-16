<template>
  <div v-if="single !== undefined" class="article">
    <aplayer :music="audioData" :volume="0.5" />

    <h1>{{ single.title }}</h1>
    <div v-if="single !== undefined" class="article--body">
      <p>{{ single.description }}</p>
    </div>
    <footer v-if="single.show">
      <div class="article-author">
        <div :style="getBackgroundImage(single)" class="author-logo">
          <img :src="single.show.image_url" :alt="single.show.title" style="display: none;">
        </div>
        <div class="article-author-info">
          <router-link :to="{name: 'podcast.show', params: { show: single.show.slug }}">
            {{ single.show.title }}
          </router-link>
          <p>{{ single.show.description }}</p>
        </div>
      </div>
    </footer>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import Aplayer from 'vue-aplayer'

export default {
  middleware: 'auth',
  layout: 'inner',
  name: 'PodcastSingle',

  components: {
    Aplayer
  },

  metaInfo () {
    return {title: this.single.title === undefined ? 'Podcast' : this.single.title}
  },

  data: () => ({}),

  computed: {
    audioData () {
      if (this.single.show === undefined) {
        return {
          src: this.single.audio_url
        }
      }

      return {
        title: this.single.title,
        artist: this.single.show.title,
        src: this.single.audio_url,
        pic: this.single.show.image_url
      }
    },
    ...mapGetters({
      single: 'podcasts/single'
    })
  },

  created () {
    let video = {
      'show': this.$route.params.show,
      'slug': this.$route.params.slug
    }

    this.$store.dispatch('podcasts/fetchBySlug', video)
  },

  methods: {
    getBackgroundImage (podcast) {
      return `background-image: url("${podcast.show.image_url}")`
    },
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
      margin: 0 0 20px;
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
