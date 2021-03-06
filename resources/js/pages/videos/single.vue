<template>
  <div v-if="single" class="article">
    <bookmark :bookmarked="single.bookmarked" :id="single.id" type="video" />
    <div class="thumbnail-wrapper">
      <iframe v-if="playerVisible" id="ytplayer" :src="youtubeLink" type="text/html" width="100%" :height="calculatePlayerHeight()"
              frameborder="0" allowfullscreen style="margin-bottom: -10px;"
      />
      <div v-else class="thumbnail" :style="getVideoThumbnail()" @click="showPlayer">
        <button @click="showPlayer">
          <fa :icon="['fab', 'youtube']" size="5x" />
        </button>
      </div>
    </div>
    <h1>{{ single.title }}</h1>
    <div class="additional-info">
      <span>Published at: <b>{{ single.published_at }}</b></span>
      <span>Updated at: <b>{{ single.updated_at }}</b></span>
    </div>
    <div v-if="single !== undefined" class="article--body">
      <p v-for="(item, key) in preparedDescription(single.description)" :key="key">
        {{ item }}
      </p>
    </div>
    <footer v-if="single.channel">
      <div class="article-author">
        <div :style="getChannelImage()" class="author-logo">
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
import Bookmark from '../../components/Bookmark'

export default {
  layout: 'inner',
  name: 'VideoSingle',

  components: {
    Bookmark
  },

  metaInfo () {
    return {
      title: this.single.title === undefined ? 'Video' : this.single.title,
      meta: [
        { name: 'description', content: this.single.description },
        { property: 'og:title', content: this.single.title },
        { property: 'og:site_name', content: 'WebDevHub' },
        { property: 'og:type', content: 'website' },
        { property: 'og:url', content: window.location.href },
        { property: 'og:image', content: this.single.image_src },
        { property: 'og:description', content: this.single.description },
        { name: 'twitter:card', content: 'summary' },
        { name: 'twitter:site', content: window.location.href },
        { name: 'twitter:title', content: this.single.title },
        { name: 'twitter:description', content: this.single.description },
        { name: 'twitter:image:src', content: this.single.image_src },
        { itemprop: 'name', content: this.single.title },
        { itemprop: 'description', content: this.single.description },
        { itemprop: 'image', content: this.single.image_src }
      ]
    }
  },

  data: () => ({
    playerVisible: false
  }),

  computed: {
    youtubeLink () {
      return 'https://www.youtube.com/embed/' + this.single.youtube_id + '?autoplay=1&mute=1'
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

    this.$store.dispatch('videos/fetchBySlug', video).then(() => {
      let breadcrumbs = [
        { title: this.$t('videos.videos'), route: { name: 'video' } },
        { title: this.single.channel.title, route: { name: 'video.channel', params: { channel: this.single.channel.slug } } },
        { title: this.single.title,
          route: { name: 'video.single', params: { channel: this.single.channel.slug, slug: this.single.slug } }
        }
      ]

      this.$store.dispatch('breadcrumbs/setBreadcrumbs', breadcrumbs)
    })
  },

  methods: {
    preparedDescription (text) {
      if (text === undefined) {
        return null
      }

      let replacedEntersText = text.replace(new RegExp(/\n\n/, 'g'), '\n')
      return replacedEntersText.match(/(.*?)\n/g)
    },
    getChannelImage () {
      return `background-image: url("${this.single.channel.image_src}")`
    },
    getVideoThumbnail () {
      return `background-image: url("${this.single.image_src}"); height:` + this.calculatePlayerHeight()
    },
    calculatePlayerHeight () {
      let content = document.querySelector('.content')
      let contentWidth = parseInt(window.getComputedStyle(content).getPropertyValue('width'))
      let pixelsPerPointRatio = contentWidth / 16
      return (pixelsPerPointRatio * 9) + 'px'
    },
    showPlayer () {
      this.playerVisible = true
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
  color: #FFF;
  padding-bottom: 20px;
  &::-webkit-scrollbar {
    width: 10px;
    display: none;
  }
  &--image {
    background-size: cover;
    background-position: center;
    width: 100%;
    height: 500px;
  }
  .thumbnail {
    background-position: center;
    background-size: cover;
    display: flex;
    position: relative;
    &:before {
      content: '';
      width: 100%;
      height: 100%;
      position: absolute;
      left: 0;
      top: 0;
      background: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.7));
    }
    &:hover {
      cursor: pointer;
      button{
        transform: scale(1.3);
        cursor: pointer;
        transition: all .3s;
      }
    }
    button {
      margin: auto;
      z-index: 2;
      position: relative;
      transition: all .3s;
      &:before {
        content: '';
        width: 50%;
        height: 50%;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        background: #FFF;
        z-index: -1;
      }
      svg path {
        fill: #cd201f;
      }
    }
  }
  h1 {
    color: #FFF;
    margin: 0;
    padding: 20px;
    background-color: $default-black;
    text-align: center;
  }
  .additional-info {
    display: flex;
    flex-direction: column;
    float: right;
    width: 100%;
    align-items: flex-end;
    padding: 10px;
    b {
      color: $pink;
    }
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

@media #{$mobile} {
  .article {
    h1 {
      font-size: 24px;
    }
  }
}
</style>
