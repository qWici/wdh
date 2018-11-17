<template>
  <div class="stream">
    <twitch-player
      :channel="this.$route.params.id"
      :width="playerOptions.width"
      :height="playerOptions.height"
      :autoplay="playerOptions.autoplay"
      :volume="playerOptions.volume"/>
    <div class="stream--tags">
      <ul>
        <li v-for="(item, key) in tags"
            :key="key">
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

export default {
  middleware: 'auth',
  layout: 'inner',
  name: 'StreamSingle',

  components: {
    TwitchPlayer
  },

  metaInfo () {
    return {
      title: `Stream ${this.$route.params.id}`,
      meta: [
        {property: 'og:title', content: `Web development stream ${this.$route.params.id} on WebDevHub`},
        {property: 'og:site_name', content: 'WebDevHub'},
        {property: 'og:type', content: 'website'},
        {property: 'og:url', content: window.location.href},
        {property: 'og:description', content: `Web development stream ${this.$route.params.id} on WebDevHub`},
        {name: 'twitter:card', content: 'summary'},
        {name: 'twitter:site', content: window.location.href},
        {name: 'twitter:title', content: `Web development stream ${this.$route.params.id} on WebDevHub`},
        {name: 'twitter:description', content: `Web development stream ${this.$route.params.id} on WebDevHub`},
        {itemprop: 'name', content: `Web development stream ${this.$route.params.id} on WebDevHub`},
        {itemprop: 'description', content: `Web development stream ${this.$route.params.id} on WebDevHub`},
      ]
    }
  },

  data: () => ({
    playerOptions: {
      width: '100%',
      height: '680px',
      autoplay: false,
      volume: 0.5
    }
  }),

  computed: mapGetters({
    tags: 'streams/tags'
  }),

  created () {
    this.$store.dispatch('streams/fetchStreamTags', this.$route.params.id)
  },

  methods: {}
}
</script>

<style scoped lang="scss">
@import "../../../sass/vars";

.stream {
  padding-top: 20px;
  width: 100%;
  height: 680px;
  display: block;
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
</style>
