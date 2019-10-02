<template>
  <div class="suggest-page">
<!--    @TODO: Adaptive-->
<!--    @TODO: Server side-->
    <form>
      <h1>
        {{ $t('suggest.i_suggest') }}
        <span class="inline-select" @click="showSelectOptions('type', $event)">{{ $t(typeTitle) }}</span>
      </h1>

      <div class="dynamic-select" v-if="dynamicSelect.isVisible" :style="dynamicSelectStyles" ref="selectType">
        <ul>
          <li v-for="(item, key) in dynamicSelect.items" @click="selectOption(item.type)" :key="key">
            {{ $t(item.title) }}
          </li>
        </ul>
      </div>

      <div class="input-group">
        <input type="text" id="website" name="website" :placeholder="typePlaceholder">
        <button>{{ $t('suggest.suggest')}}</button>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  layout: 'inner',
  name: 'Suggest',

  mounted () {
    this.type = this.$route.params.type ? this.$route.params.type : 'author'
    this.typeTitle = this.typeTitles.filter(item => item.type === this.type)[0].title
    this.typePlaceholder = this.typePlaceholders.filter(item => item.type === this.type)[0].value
  },

  components: {},

  computed: {
    dynamicSelectStyles () {
      let top = this.dynamicSelect.position.top
      let left = this.dynamicSelect.position.left
      let width = this.dynamicSelect.size.width
      return `top: ${top}px; left: ${left}px; width: ${width}px`
    }
  },

  data: () => ({
    type: 'author',
    typeTitle: 'suggest.articles_author',
    typePlaceholder: 'https://www.mycoolauthor.com/',
    typeTitles: [
      { type: 'author', title: 'suggest.articles_author' },
      { type: 'show', title: 'suggest.podcast_show' },
      { type: 'channel', title: 'suggest.youtube_channel' },
      { type: 'stream', title: 'suggest.twitch_channel' }
    ],
    typePlaceholders: [
      { type: 'author', value: 'https://www.mycoolauthor.com/' },
      { type: 'show', value: 'https://www.coolshow.com/' },
      { type: 'channel', value: 'https://youtube.com/ChromeDevelopers' },
      { type: 'stream', value: 'https://www.twitch.tv/devkucher/' }
    ],
    dynamicSelect: {
      targetElement: null,
      isVisible: false,
      position: {
        top: 0,
        left: 0
      },
      size: {
        width: 0
      },
      items: {}
    }
  }),

  methods: {
    checkType (requestedType) {
      return requestedType === this.type
    },
    showSelectOptions (type, e) {
      if (this.dynamicSelect.isVisible) {
        this.dynamicSelect.isVisible = false
        return false
      }
      e.preventDefault()
      this.dynamicSelect.targetElement = e.target
      const target = this.dynamicSelect.targetElement
      const offsets = {
        left: target.offsetLeft,
        top: target.offsetTop + target.offsetHeight
      }

      this.generateSelectItems(type)
      this.showSelect()
      this.moveSelect(offsets.top, offsets.left)
      this.resizeSelect()
    },
    generateSelectItems (type) {
      if (type === 'type') {
        this.dynamicSelect.items = this.typeTitles.filter(item => item.type !== this.type)
      }
    },
    showSelect () {
      this.dynamicSelect.isVisible = true
    },
    moveSelect (top, left) {
      this.dynamicSelect.position.top = top
      this.dynamicSelect.position.left = left
    },
    resizeSelect () {
      this.dynamicSelect.size.width = this.dynamicSelect.targetElement.offsetWidth
    },
    selectOption (type) {
      this.dynamicSelect.isVisible = false
      this.updateType(type)
    },
    updateType (type) {
      this.type = type
      this.typeTitle = this.typeTitles.filter(item => item.type === this.type)[0].title
      this.typePlaceholder = this.typePlaceholders.filter(item => item.type === this.type)[0].value
    }
  }
}
</script>

<style scoped lang="scss">
@import "../../sass/elements/home";
.suggest-page {
  height: calc(100vh - 80px);
  display: flex;
  form {
    display: flex;
    align-items: center;
    flex-direction: column;
    margin: auto;
  }
  h1 {
    color: #FFF;
    text-transform: uppercase;
    margin: 0 0 20px;
    font-size: 36px;
  }
  .inline-select {
    color: #f1356a;
    border-bottom: 2px dashed #ed3567;
    &:hover {
      cursor: pointer;
    }
  }
  .input-group {
    width: 100%;
    display: flex;
    justify-content: space-between;
    input {
      width: 100%;
      border-radius: 5px 0 0 5px;
      padding: 0 15px;
      font-size: 16px;
      color: #000;
    }
    button {
      color: #FFF;
      font-weight: bold;
      font-size: 20px;
      padding: 10px 15px;
      border-radius: 0 5px 5px 0;
      background: #33b585;
      &:hover {
        background: darken(#33b585, 10%);
        cursor: pointer;
      }
    }
  }
  .dynamic-select {
    position: absolute;
    border: 2px dashed #ed3567;
    border-top: none;
    min-height: 30px;
    transition: all .4s;
    background-color: #191d3b;
    li {
      color: #fff;
      padding: 10px;
      &:hover {
        cursor: pointer;
        background-color: rgba(241, 53, 105, 0.6);
      }
      &:last-child {
        margin-bottom: 0;
      }
    }
  }
}
</style>
