<template>
  <div class="author-info" itemprop="author" itemscope itemtype="https://schema.org/Person">
    <div class="author-logo" :style="getAuthorLogo(logo)">
      <meta itemprop="image" :content="logo">
      <img :src="logo" :alt="name">
    </div>
    <div class="author-data">
      <h1 itemprop="name">
        {{ name }}
      </h1>
      <p>{{ about }}</p>
      <a target="_blank" rel="nofollow" :href="siteUrl">Website</a>
      <meta itemprop="url" :content="siteUrl">
    </div>
  </div>
</template>

<script>
export default {
  name: 'WAuthorInfo',

  props: {
    name: { type: String, default: null, required: true },
    about: { type: String, default: null },
    logo: { type: String, default: null },
    siteUrl: { type: String, default: null },
    id: { type: Number, default: 0, required: true },
    type: {
      type: String,
      default: null,
      validator: value => {
        return ['article', 'video', 'podcast'].indexOf(value) !== -1
      }
    }
  },

  methods: {
    getAuthorLogo (src) {
      return `background-image: url('${src}')`
    }
  }
}
</script>

<style scoped lang="scss">
@import "../../sass/vars";
.author-info {
  display: flex;
  margin-bottom: 15px;
  .author-logo {
    margin-right: 25px;
    width: 100px;
    min-width: 100px;
    height: 100px;
    background-size: 90%;
    background-position: center;
    background-repeat: no-repeat;
    background-color: #FFF;
    border-radius: 5px;
    img {
      display: none;
    }
  }
  .author-data {
    h1 {
      margin-top: 0;
      color: #fff;
      line-height: 1;
      font-size: 36px;
    }
    p {
      color: #d0d0d0;
      margin-top: 10px;
      margin-bottom: 10px;
    }
    a {
      display: inline-block;
      background-color: #13193b;
      padding: 5px 10px;
      font-size: 14px;
      color: #FFF;
      border-radius: 5px;
      &:hover {
        background-color: #0eb87d;
      }
    }
  }
}
@media #{$mobile} {
  .author-info {
    flex-wrap: wrap;
    justify-content: center;
    .author-logo {
      margin-right: 0;
      margin-bottom: 25px;
    }
    .author-data {
      text-align: center;
      h1 {
        font-size: 24px;
      }
      p {
        font-size: 14px;
      }
    }
  }
}
</style>
