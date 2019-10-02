<template>
  <div class="home">
    <w-author-info
      v-if="author"
      :name="author.name"
      :about="author.about"
      :logo="author.logo"
      :site-url="author.site_url"
      :id="author.id"
      :type="type"
    />
    <div class="content-wrapper">
      <ContentItem
        v-for="(item, key) in items"
        :key="key"
        :src="item.image_src"
        :link="getArticleLink(item)"
        :title="item.title"
        :author="item.author.name"
        :date="item.date"
        :lang="item.author.language"
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
  name: 'ArticleAuthor',

  components: {
    ContentItem,
    WAuthorInfo,
    InfiniteLoading
  },

  metaInfo () {
    return { title: this.getPageTitle() }
  },

  data: () => ({
    type: 'article',
    page: 0,
    countItems: 0,
    infinityState: null,
    author: null
  }),

  computed: mapGetters({
    items: 'articles/author'
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
    this.$store.dispatch('articles/clearState')
  },

  methods: {
    infiniteHandler ($state) {
      this.infinityState = $state
      let requestData = {
        'author': this.$route.params.author,
        'pageNumber': this.page + 1
      }
      this.$store.dispatch('articles/fetchByAuthorSlug', requestData).then(() => {
        let breadcrumbs = [
          { title: this.$t('articles.articles'), route: { name: 'article' } },
          { title: this.items[0].author.name, route: { name: 'article.author', params: { author: this.$route.params.author } } }
        ]

        this.$store.dispatch('breadcrumbs/setBreadcrumbs', breadcrumbs).then(() => {
          this.author = this.items[0].author
        })
      })
    },
    getArticleLink (article) {
      return { author: article.author.slug, slug: article.slug }
    },
    getPageTitle () {
      if (this.items.length > 0) {
        return this.$t('last_publications') + ' ' + this.items[0].author.name
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
