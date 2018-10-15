<template>
    <a class="content-item" :href="link" target="_blank">
        <div class="img-wrapper" :style="'background-image: url(' + src + ')'">
            <img :src="src" :alt="title" style="display: none">
        </div>
        <span class="item-info">
            <span class="title">{{ title }}</span>
            <span class="data">
                <span class="date" v-if="type !== 'stream'">{{ date }}</span>
                <span class="author">{{ author }}</span>
            </span>
        </span>
    </a>
</template>

<script>
  export default {
    name: "ContentItem",

    props: {
      src: { type: String, default: null }, // @TODO Add default image
      title: { type: String, required: true },
      link: { type: String, required: true },
      author: { type: String, required: true },
      date: { type: String, default: null },
      lang: { type: String, default: null },
      type: {
        validator: value => {
            return ['article', 'stream', 'video', 'podcast'].indexOf(value) !== -1
        },
      }
    }
  }
</script>

<style scoped lang="scss">
.content-item {
    background: linear-gradient(to right, #443B6D 0%, #36385F 100%);
    border-radius: 5px;
    overflow: hidden;
    position: relative;
    &:hover .item-info{
        bottom: 0;
        transition: all .2s ease-in;
    }
    .img-wrapper {
        height: 340px;
        overflow: hidden;
        background-size: cover;
        background-position: center;
        position: relative;
        &:after {
            content: '';
            width: calc(100% + 1px);
            height: 100%;
            top: 0;
            position: absolute;
            background-image: -webkit-gradient(linear, left top, left bottom, from(transparent), to(rgba(0, 0, 0, 0.85)));
            background-image: linear-gradient(to bottom, transparent, rgba(0, 0, 0, 0.85));
        }
    }
    .item-info {
        position: absolute;
        bottom: -40px;
        left: 0;
        padding: 10px 20px 20px;
        color: #FFF;
        width: 100%;
        transition: all .2s ease-out;
        .data {
            display: flex;
            justify-content: space-between;
            opacity: .6;
            font-size: 13px;
        }
        .title {
            font-size: 18px;
            margin: 0 0 15px;
            padding: 0;
            line-height: 1.6;
            display: block;
            color: #FFF;
        }
    }
}
</style>