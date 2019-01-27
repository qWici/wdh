<template>
  <div class="home">
    <h2 v-show="items.length > 0">
      {{ getPageTitle() }}
    </h2>
    <div class="content-wrapper">
      <ContentItem
        v-for="(item, key) in items"
        :key="key"
        :src="item.image_src"
        :link="getVideoLink(item)"
        :title="item.title"
        :author="item.channel.title"
        :date="item.published_at"
        :lang="item.lang"
        :type="type"
      />
    </div>
    <InfiniteLoading :distance="0" spinner="spiral" @infinite="infiniteHandler">
      <div slot="no-more" />
    </InfiniteLoading>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import ContentItem from '../../components/ContentItem'
import InfiniteLoading from 'vue-infinite-loading'

export default {
  layout: 'inner',
  name: 'VideoChannel',

  components: {
    ContentItem,
    InfiniteLoading
  },

  metaInfo () {
    return { title: this.getPageTitle() }
  },

  data: () => ({
    type: 'video',
    page: 0,
    countItems: 0,
    infinityState: null
  }),

  computed: mapGetters({
    items: 'videos/channel'
  }),

  watch: {
    items (newItems) {
      this.page += 1
      if (this.countItems === newItems.length) {
        this.infinityState.complete()
      } else {
        this.countItems = newItems.length
        this.infinityState.loaded()
      }
    }
  },

  destroyed () {
    this.$store.dispatch('videos/clearState')
  },

  methods: {
    infiniteHandler ($state) {
      this.infinityState = $state
      let requestData = {
        'channel': this.$route.params.channel,
        'pageNumber': this.page + 1
      }
      this.$store.dispatch('videos/fetchByChannelSlug', requestData).then(() => {
        let breadcrumbs = [
          { title: this.$t('videos'), route: { name: 'video' } },
          { title: this.items[0].channel.title, route: { name: 'video.channel', params: { channel: this.$route.params.channel } } }
        ]

        this.$store.dispatch('breadcrumbs/setBreadcrumbs', breadcrumbs)
      })
    },
    getVideoLink (video) {
      return { author: video.channel.slug, slug: video.slug }
    },
    getPageTitle () {
      if (this.items.length > 0) {
        return this.$t('last_publications') + ' ' + this.items[0].channel.title
      }
      return this.$t('last_publications')
    }
  }
}
</script>

<style scoped lang="scss">
  @import "../../../sass/elements/home";
</style>
