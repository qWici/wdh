<template>
  <div v-if="single" class="article">
    <iframe id="ytplayer" :src="youtubeLink" type="text/html" width="1025" height="576.5625"
            frameborder="0" allowfullscreen/>
    <h1>{{ single.title }}</h1>
    <div v-if="single !== undefined" class="article--body">
      <p v-for="(item, key) in preparedDescription(single.description)" :key="key">
        {{ item }}
      </p>
    </div>
    <footer v-if="single.author">
      <div class="article-author">
        <img :src="single.author.logo" :alt="single.author.name">
        <div class="article-author-info">
          <a :href="single.author.site_url">{{ single.author.name }}</a>
          <p>{{ single.author.about }}</p>
        </div>
      </div>
      <a :href="single.link">Read full article</a>
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
  background: $default-black;
  border-radius: 5px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.4);
  overflow: hidden;
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
    background-color: $pink;
  }
  &--body {
    padding: 20px;
    color: #FFF;
  }
  footer {
    display: flex;
    justify-content: space-between;
    padding: 0 20px 20px;
    align-items: center;
    > a {
      display: block;
      background: linear-gradient(135deg, #3260FE 0%, #3A9CFF 100%);
      color: #FFF;
      padding: 10px 20px;
      border-radius: 5px;
      font-weight: bold;
      text-align: center;
    }
    & .article-author {
      display: flex;
      max-width: calc(100% - 200px);
      img {
        width: auto;
        max-height: 100px;
        margin-right: 20px;
        border-radius: 50%;
      }
    }
  }
}
</style>
