<template>
  <div class="home">
    <w-author-info
      v-if="show"
      :name="show.title"
      :about="show.description"
      :logo="show.image_url"
      :site-url="show.site_url"
      :id="show.id"
      :type="type"
    />
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
import WAuthorInfo from '../../components/WAuthorInfo'
import InfiniteLoading from 'vue-infinite-loading'

export default {
  layout: 'inner',
  name: 'PodcastShow',

  components: {
    ContentItem,
    WAuthorInfo,
    InfiniteLoading
  },

  metaInfo () {
    return { title: this.getPageTitle() }
  },

  data: () => ({
    type: 'podcast',
    page: 0,
    countItems: 0,
    infinityState: null,
    show: null
  }),

  computed: mapGetters({
    items: 'podcasts/show'
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
      let requestData = {
        'show': this.$route.params.show,
        'pageNumber': this.page + 1
      }
      this.$store.dispatch('podcasts/fetchByShowSlug', requestData).then(() => {
        let breadcrumbs = [
          { title: 'Podcasts', route: { name: 'podcast' } },
          { title: this.items[0].show.title, route: { name: 'podcast.show', params: { author: this.$route.params.show } } }
        ]

        this.$store.dispatch('breadcrumbs/setBreadcrumbs', breadcrumbs).then(() => {
          this.show = this.items[0].show
        })
      })
    },
    getPodcastLink (podcast) {
      return { show: podcast.show.slug, slug: podcast.slug }
    },
    getPageTitle () {
      if (this.items.length > 0) {
        return this.$t('last_publications') + ' ' + this.items[0].show.title
      }
      return this.$t('last_publications')
    }
  }
}
</script>

<style scoped lang="scss">
  @import "../../../sass/elements/home";
  .home {
    height: calc(100vh - 142px);
  }
</style>
