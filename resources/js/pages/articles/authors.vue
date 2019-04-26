<template>
  <div class="home">
    <h2>
      {{ $t('authors') }}
    </h2>
    <div class="content-wrapper">
      <ContentItem
        v-for="(item, key) in authors"
        :key="key"
        :src="item.logo"
        :link="getAuthorLink(item)"
        :title="item.name"
        :author="item.name"
        :lang="item.language"
        :type="type"
      />
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import ContentItem from '../../components/ContentItem'

export default {
  layout: 'inner',
  name: 'AuthorsList',

  components: {
    ContentItem
  },

  metaInfo () {
    return { title: this.$t('authors') }
  },

  data: () => ({
    type: 'author'
  }),

  computed: mapGetters({
    authors: 'articles/authors'
  }),

  created () {
    this.$store.dispatch('articles/fetchAuthors')
  },

  methods: {
    getAuthorLink (author) {
      return { author: author.slug }
    }
  }
}
</script>

<style scoped lang="scss">
    @import "../../../sass/elements/home";
</style>
