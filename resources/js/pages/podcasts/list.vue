<template>
  <div class="home">
    <div class="content-header">
      <h2 v-show="items.length > 0">
        {{ pageTitle }}
      </h2>
      <content-filter @updateTitle="updateTitle" @filter="filter" content-type="podcasts" />
    </div>
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
import ContentFilter from '../../components/ContentFilter'
import InfiniteLoading from 'vue-infinite-loading'

export default {
  layout: 'inner',
  name: 'PodcastsList',

  components: {
    ContentItem,
    ContentFilter,
    InfiniteLoading
  },

  metaInfo () {
    return { title: this.$t('podcasts') }
  },

  data: () => ({
    type: 'podcast',
    page: 0,
    countItems: 0,
    infinityState: null,
    pageTitle: ''
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

  mounted () {
    this.pageTitle = this.$t('last_publications')
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
    },
    updateTitle (filters) {
      if (filters) {
        this.pageTitle = this.$tc('last_publications', null, { filters: filters })
        return
      }

      this.pageTitle = this.$t('last_publications')
    },
    filter (filters) {
      console.log(filters)
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
