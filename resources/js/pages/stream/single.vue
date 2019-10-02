<template>
  <div class="stream">
    <bookmark :bookmarked="single.bookmarked" :id="single.id" type="stream" />
    <div class="thumbnail-wrapper">
      <TwitchPlayer
        v-if="playerVisible"
        :channel="this.$route.params.id"
        :width="playerOptions.width"
        :height="calculatePlayerHeight()"
        :autoplay="playerOptions.autoplay"
        :volume="playerOptions.volume"
      />
      <div v-else class="thumbnail" :style="getStreamThumbnail()" @click="showPlayer">
        <button @click="showPlayer">
          <fa :icon="['fas', 'play']" size="3x" />
        </button>
      </div>
    </div>
    <div class="stream--tags">
      <ul>
        <li v-for="(item, key) in tags"
            :key="key"
        >
          <router-link :to="{ name: 'stream.tag', params: { id: item.tag }}">
            {{ item.tag }}
          </router-link>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import TwitchPlayer from '../../components/TwitchPlayer'
import Bookmark from '../../components/Bookmark'

export default {
  layout: 'inner',
  name: 'StreamSingle',

  components: {
    TwitchPlayer,
    Bookmark
  },

  metaInfo () {
    return {
      title: `Stream ${this.$route.params.id}`,
      meta: [
        { name: 'description', content: `Web development stream ${this.$route.params.id} on WebDevHub` },
        { property: 'og:title', content: `Web development stream ${this.$route.params.id} on WebDevHub` },
        { property: 'og:site_name', content: 'WebDevHub' },
        { property: 'og:type', content: 'website' },
        { property: 'og:url', content: window.location.href },
        { property: 'og:description', content: `Web development stream ${this.$route.params.id} on WebDevHub` },
        { name: 'twitter:card', content: 'summary' },
        { name: 'twitter:site', content: window.location.href },
        { name: 'twitter:title', content: `Web development stream ${this.$route.params.id} on WebDevHub` },
        { name: 'twitter:description', content: `Web development stream ${this.$route.params.id} on WebDevHub` },
        { itemprop: 'name', content: `Web development stream ${this.$route.params.id} on WebDevHub` },
        { itemprop: 'description', content: `Web development stream ${this.$route.params.id} on WebDevHub` }
      ]
    }
  },

  data: () => ({
    playerVisible: false,
    playerOptions: {
      width: '100%',
      autoplay: true,
      volume: 0.5
    }
  }),

  computed: mapGetters({
    tags: 'streams/tags',
    single: 'streams/single'
  }),

  created () {
    this.$store.dispatch('streams/fetchStreamBySlug', this.$route.params.id).then(() => {
      this.$store.dispatch('streams/fetchStreamTags', this.$route.params.id).then(() => {
        let breadcrumbs = [
          { title: this.$t('streams.streams'), route: { name: 'stream' } },
          { title: this.$route.params.id, route: { name: 'stream.single', params: { id: this.$route.params.id } } }
        ]

        this.$store.dispatch('breadcrumbs/setBreadcrumbs', breadcrumbs)
      })
    })
  },

  methods: {
    calculatePlayerHeight () {
      let content = document.querySelector('.content')
      let contentWidth = parseInt(window.getComputedStyle(content).getPropertyValue('width'))
      let pixelsPerPointRatio = contentWidth / 16
      return (pixelsPerPointRatio * 9) + 'px'
    },
    getStreamThumbnail () {
      return `background-image: url("https://static-cdn.jtvnw.net/previews-ttv/live_user_${this.$route.params.id}-600x340.jpg"); height:` + this.calculatePlayerHeight()
    },
    showPlayer () {
      this.playerVisible = true
    }
  }
}
</script>

<style lang="scss">
#player {
  display: flex;
}
</style>

<style scoped lang="scss">
@import "../../../sass/vars";

.stream {
  margin-top: 20px;
  width: 100%;
  display: block;
  padding-bottom: 20px;
  &::-webkit-scrollbar {
    width: 10px;
    display: none;
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
        box-shadow: 0 5px 10px rgba(0,0,0,0.7);
      }
    }
    button {
      margin: auto;
      z-index: 2;
      width: 100px;
      height: 100px;
      border-radius: 50%;
      background: radial-gradient(#6441A4, #423a6f);
      display: flex;
      justify-content: center;
      align-items: center;
      transition: all .3s;
      svg path {
        fill: #FFF;
      }
    }
  }
  &--tags {
    background: linear-gradient(to left, #423a6f 0%, #272c5a 100%);
    border-radius: 0 0 5px 5px;
    box-shadow: 0 0 3px rgba(0,0,0,.3);
    ul {
      display: flex;
      align-items: center;
      li {
        margin-right: 15px;
        + li {
          margin-top: 0;
        }
        &:last-child {
          margin-right: 0;
        }
        a {
          display: block;
          padding: 10px;
          color: #FFF;
          font-size: 14px;
          font-weight: bold;
          &:hover {
            color: $pink
          }
        }
      }
    }
  }
}
@media only screen and (max-width: 768px) {
  .stream {
    padding-top: 0;
  }
}
</style>
