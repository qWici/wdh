<template>
  <div class="authors">
    <h2>{{ $t('videos.channels') }}</h2>
    <div class="production content-wrapper">
      <AuthorItem
        v-for="(item, key) in channels"
        :key="key"
        :src="item.image_src"
        :link="getChannelLink(item)"
        :title="item.title"
        :lang="item.country"
        :type="type"
      />
      <suggest-button type="channel" />
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import AuthorItem from '../../components/AuthorItem'
import SuggestButton from '../../components/SuggestButton'

export default {
  layout: 'inner',
  name: 'ChannelsList',

  components: {
    AuthorItem,
    SuggestButton
  },

  metaInfo () {
    return { title: this.$t('videos.channels') }
  },

  data: () => ({
    type: 'video'
  }),

  computed: mapGetters({
    channels: 'videos/channels'
  }),

  created () {
    this.$store.dispatch('videos/fetchChannels')
  },

  methods: {
    getChannelLink (channel) {
      return { channel: channel.slug }
    }
  }
}
</script>

<style scoped lang="scss">
@import "../../../sass/elements/home";
</style>
