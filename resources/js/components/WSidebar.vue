<template>
    <aside class="sidebar">
        <div class="user" v-if="user">
            <img :src="userPhoto" :alt="user.name" class="user__img">
            <div>
                <span class="user__name">{{ user.nickname }}</span>
                <span class="user__specs" v-show="user.specialization">{{ user.specialization }}</span>
            </div>
        </div>
        <nav class="content-nav">
            <ul>
                <li>
                    <div class="content-nav__category">
                        <span class="content-nav__category__icon gradient-pink">
                            <fa :icon="['far', 'newspaper']" fixed-width/>
                        </span>
                        <span class="content-nav__category__title">{{ $t('articles') }}</span>
                    </div>
                </li>
                <li>
                    <div class="content-nav__category">
                        <span class="content-nav__category__icon gradient-purple-to-pink">
                            <fa :icon="'tv'" fixed-width/>
                        </span>
                        <span class="content-nav__category__title">{{ $t('streams') }}</span>
                    </div>
                </li>
                <li>
                    <div class="content-nav__category">
                        <span class="content-nav__category__icon gradient-blue">
                            <fa :icon="['fab', 'youtube']" fixed-width/>
                        </span>
                        <span class="content-nav__category__title">{{ $t('videos') }}</span>
                    </div>
                </li>
                <li>
                    <div class="content-nav__category">
                        <span class="content-nav__category__icon gradient-crimson">
                            <fa :icon="['fas', 'microphone']" fixed-width/>
                        </span>
                        <span class="content-nav__category__title">{{ $t('podcasts') }}</span>
                    </div>
                </li>
            </ul>
        </nav>
    </aside>
</template>

<script>
  import { mapGetters } from 'vuex'

  export default {
    computed: mapGetters({
      user: 'auth/user',
      userPhoto: 'auth/userPhoto'
    }),
  }
</script>