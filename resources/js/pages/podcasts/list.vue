<template>
  <div class="home">
    <h2 v-show="items.length > 0">
      {{ $t('last_publications') }}
    </h2>
    <div class="content-wrapper">
      <ContentItem
        v-for="(item, key) in items"
        :key="key"
        :src="item.show.image_url"
        :link="getPodcastLink(item)"
        :title="item.title"
        :author="item.show.title"
        :date="item.published_at"
        :lang="item.show.language"
        :type="type"
      />
      <InfiniteLoading :distance="0" spinner="spiral" @infinite="infiniteHandler">
        <div slot="no-more" />
      </InfiniteLoading>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import ContentItem from '../../components/ContentItem'
import InfiniteLoading from 'vue-infinite-loading'

export default {
  middleware: 'auth',
  layout: 'inner',
  name: 'PodcastsList',

  components: {
    ContentItem,
    InfiniteLoading
  },

  metaInfo () {
    return { title: this.$t('podcasts') }
  },

  data: () => ({
    type: 'podcast',
    page: 0,
    countItems: 0,
    infinityState: null
  }),

  computed: mapGetters({
    items: 'podcasts/paginate'
  }),

  watch: {
    items (newItems) {
      if (this.infinityState === null) { return false }

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
    this.$store.dispatch('podcasts/clearState')
  },

  methods: {
    infiniteHandler ($state) {
      this.infinityState = $state
      this.$store.dispatch('podcasts/fetchPaginatePodcasts', this.page + 1)
    },
    getPodcastLink (podcast) {
      return { show: podcast.show.slug, slug: podcast.slug }
    }
  }
}
</script>

<style lang="scss">
  .content-wrapper {
    > .content-item > .img-wrapper {
      background-size: 100%!important;
      background-repeat: no-repeat;
      background-color: #000;
    }
  }
</style>

<style scoped lang="scss">
  @import "../../../sass/elements/home";
</style>
