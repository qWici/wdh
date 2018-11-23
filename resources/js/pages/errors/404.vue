<template>
  <div class="error404">
    <img src="/img/404.png" alt="">

    <h2>{{ $t('page_not_found') }}</h2>
    <RouterLink :to="{ name: 'welcome' }" class="button is-link is-medium is-rounded">
      {{ $t('go_home') }}
    </RouterLink>
  </div>
</template>

<script>
export default {
  name: 'NotFound'
}
</script>

<style scoped lang="scss">
  .error404 {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    h2 {
      color: #FFF;
      margin-bottom: 30px;
      font-weight: bold;
    }
    a {
      background: linear-gradient(-4deg, #DB50CD 0%, #FD7FB6 100%);
      &:hover {
        background: linear-gradient(-4deg, #FD7FB6 0%, #DB50CD 100%);
      }
    }
  }
</style>
