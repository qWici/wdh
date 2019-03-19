<template>
  <div class="tag" :title="this.$t('remove_filter')" @click="remove">
    <strong>{{ title }}</strong>
    <span><fa icon="filter"/></span>
  </div>
</template>

<script>
export default {
  name: 'WTag',

  props: {
    title: { type: String, default: null, required: true },
    val: { type: String, default: null, required: true }
  },

  methods: {
    remove () {
      this.$emit('removeTag', this.val)
    }
  }
}
</script>

<style scoped lang="scss">
.tag {
  display: flex;
  background-color: #3273DC;
  height: 30px;
  justify-content: space-around;
  align-items: center;
  border-radius: 5px;
  padding-left: 10px;
  overflow: hidden;
  &:hover {
    cursor: pointer;
    background-color: #d92b4c;
    span {
      svg {
        display: none;
      }
      &:before, &:after {
        display: block;
      }
    }
  }
  strong {
    color: #FFF;
    line-height: 1;
    font-size: 14px;
  }
  span {
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
    width: 30px;
    height: 100%;
    margin-left: 10px;
    background-color: #E8E8E8;
    svg path {
      fill: #adadad;
    }
    &:before, &:after {
      display: none;
      background-color: #101010;
      content: "";
      left: 50%;
      position: absolute;
      top: 50%;
      transform: translateX(-50%) translateY(-50%) rotate(45deg);
      transform-origin: center center;
    }
    &:before {
      height: 1px;
      width: 50%;
    }
    &:after {
      height: 50%;
      width: 1px;
    }
  }
}
</style>
