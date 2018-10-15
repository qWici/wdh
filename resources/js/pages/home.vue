<template>
  <div class="home">
    <div class="content-wrapper">
      <content-item
              v-for="(item, key) in items"
              :key="key"
              :src="item.img"
              :link="item.link"
              :title="item.title"
              :author="item.author"
              :date="item.date"
              :type="item.type"></content-item>
    </div>
  </div>
</template>

<script>
import ContentItem from '../components/ContentItem'

export default {
  middleware: 'auth',
  layout: 'inner',

  components: {
    ContentItem
  },

  metaInfo () {
    return { title: this.$t('home') }
  },

  // @TODO: Get data from server
  data: () => ({
    items: [
      { type: 'article', img: 'https://cdn-images-1.medium.com/max/696/1*WYzEn6s-Fifwrrsrgfrw7g.jpeg', title: 'Laravel — The ultimate Web Artisan Framework', link: 'https://medium.com/p/8128f46974ea', author: 'Bhadresh Laiya', date: '15 Oct 2018'},
      { type: 'stream', img: 'https://cdn-images-1.medium.com/max/1120/0*mv44WbuUtFLIAr7e.jpg', title: 'Kubernetes: deploy Laravel the easy way', link: 'https://medium.com/p/c747b769939', author: 'Keith Mifsud', date: '15 Oct 2018'},
      { type: 'video', img: 'https://cdn-images-1.medium.com/max/700/1*9H4Fh1q8LoA8Txaxf38nsQ.jpeg', title: 'Php Course in Navi Mumbai', link: 'https://medium.com/p/9b4c1d7bf92e', author: 'letsleads mumbai', date: '15 Oct 2018'},
      { type: 'podcast', img: 'https://cdn-images-1.medium.com/max/1365/1*XvwR-T--C4edkGMoYd-Urg.png', title: 'Restful API in Laravel', link: 'https://medium.com/p/5c1389c58ca0', author: 'LaraHelp', date: '14 Oct 2018'},
      { type: 'article', img: 'https://cdn-images-1.medium.com/max/600/1*fpdk-ze95bpwTJ1g6QG--A.jpeg', title: 'Что такое хорошо, и что такое плохо?', link: 'https://medium.com/p/d23d06d63034', author: 'Insolita', date: '14 Oct 2018'},
    ]
  }),
}
</script>

<style scoped lang="scss">
  .home {
    margin-top: 20px;
    padding-right: 10px;
    padding-bottom: 20px;
    overflow-y: scroll;
    height: calc(100vh - 100px);
    &::-webkit-scrollbar {
      width: 10px;
    }
    &::-webkit-scrollbar-track {
      box-shadow: inset 0 0 5px rgba(0,0,0,0.3);
      border-radius: 5px;
    }
    &::-webkit-scrollbar-thumb {
      background: #0e1430;
      border-radius: 5px;
    }
    &::-webkit-scrollbar-thumb:hover {
      background: #0e1430;
    }
  }
  .content-wrapper {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    grid-column-gap: 20px;
    grid-row-gap: 20px;
  }
</style>