<template>
  <div class="authors">
    <h2>{{ $t('podcasts.shows') }}</h2>
    <div class="production content-wrapper">
      <AuthorItem
        v-for="(item, key) in shows"
        :key="key"
        :src="item.image_url"
        :link="getShowLink(item)"
        :title="item.title"
        :lang="item.language"
        :type="type"
      />
      <suggest-button type="show" />
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import AuthorItem from '../../components/AuthorItem'
import SuggestButton from '../../components/SuggestButton'

export default {
  layout: 'inner',
  name: 'ShowsList',

  components: {
    AuthorItem,
    SuggestButton
  },

  metaInfo () {
    return { title: this.$t('podcasts.shows') }
  },

  data: () => ({
    type: 'podcast'
  }),

  computed: mapGetters({
    shows: 'podcasts/shows'
  }),

  created () {
    this.$store.dispatch('podcasts/fetchShows')
  },

  methods: {
    getShowLink (show) {
      return { show: show.slug }
    }
  }
}
</script>

<style scoped lang="scss">
@import "../../../sass/elements/home";
</style>
