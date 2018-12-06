<template>
  <div class="stream">
    <bookmark :bookmarked="single.bookmarked" :id="single.id" type="stream" />
    <TwitchPlayer
      :channel="this.$route.params.id"
      :width="playerOptions.width"
      :height="calculatePlayerHeight()"
      :autoplay="playerOptions.autoplay"
      :volume="playerOptions.volume"
    />
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
  middleware: 'auth',
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
    playerOptions: {
      width: '100%',
      autoplay: false,
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
          { title: this.$t('streams'), route: { name: 'stream' } },
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
    }
  }
}
</script>

<style scoped lang="scss">
@import "../../../sass/vars";

.stream {
  margin-top: 20px;
  width: 100%;
  height: calc(100vh - 204px);
  display: block;
  position: relative;
  &--tags {
    margin-top: -16px;
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
