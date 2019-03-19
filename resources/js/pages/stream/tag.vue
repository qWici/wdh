<template>
  <div class="home">
    <h2 class="live">
      {{ getTitle() }}
    </h2>
    <div v-show="streams.length > 0" class="content-wrapper">
      <ContentItem
        v-for="(item, key) in streams"
        :key="key"
        :src="getThumbnail(item)"
        :link="item.twitch"
        :title="item.title"
        :author="item.name"
        :date="item.date"
        :lang="item.language"
        :type="type"
        :online="item.online"
      />
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import ContentItem from '../../components/ContentItem'

export default {
  layout: 'inner',
  name: 'StreamTag',

  components: {
    ContentItem
  },

  metaInfo () {
    return { title: this.getTitle() + ' streams' }
  },

  data: () => ({
    type: 'stream'
  }),

  computed: {
    ...mapGetters({
      streams: 'streams/byTag'
    })
  },

  created () {
    this.$store.dispatch('streams/fetchStreamsByTag', this.$route.params.slug).then(() => {
      let breadcrumbs = [
        { title: this.$t('streams'), route: { name: 'stream' } },
        { title: this.$route.params.id, route: { name: 'stream.tag', params: { id: this.$route.params.id } } }
      ]

      this.$store.dispatch('breadcrumbs/setBreadcrumbs', breadcrumbs)
    })
  },

  methods: {
    getThumbnail (stream) {
      return stream.online
        ? `https://static-cdn.jtvnw.net/previews-ttv/live_user_${stream.name}-600x340.jpg`
        : stream.logo
    },
    getTitle () {
      return this.$route.params.slug.charAt(0).toUpperCase() + this.$route.params.slug.slice(1)
    }
  }
}
</script>

<style scoped lang="scss">
  @import "../../../sass/elements/home";
</style>
