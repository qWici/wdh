<template>
  <div id="welcome">
    {{ redirectUserToHome() }}
    <div class="first-section-wrapper">
      <div class="box">
        <div class="first-section">
          <h1>{{ $t('follow_everything') }}</h1>
          <span>{{ $t('faster_easier') }}</span>
          <button @click="scrollToAbout">
            {{ $t('more') }}
          </button>
        </div>
        <!-- /.first-section -->
      </div>
      <!-- /.box -->
    </div>
    <div class="box fh about-wrapper" ref="about-section">
      <div class="about">
        <h2>{{ $t('about.title') }}</h2>
        <div class="about-items">
          <div class="about--item fadeInUp">
            <div class="single-icon">
              <fa icon="atom" size="2x" />
            </div>
            <!-- /.single-icon -->
            <h4>{{ $t('about.allinone.title') }}</h4>
            <p>{{ $t('about.allinone.description') }}</p>
          </div>
          <!-- /.about--item -->
          <div class="about--item fadeInUp">
            <div class="single-icon">
              <fa icon="feather" size="2x" />
            </div>
            <!-- /.single-icon -->
            <h4>{{ $t('about.simple.title') }}</h4>
            <p>
              {{ $t('about.simple.description') }} <a href="https://github.com/qWici/wdh-resources" target="_blank">
                {{ $t('about.simple.repo') }}
              </a>
            </p>
          </div>
          <!-- /.about--item -->
          <div class="about--item fadeInUp">
            <div class="single-icon">
              <fa icon="hand-holding-usd" size="2x" />
            </div>
            <!-- /.single-icon -->
            <h4>{{ $t('about.free.title') }}</h4>
            <p>
              {{ $t('about.free.description') }} <a href="https://www.patreon.com/webdevhub" target="_blank">
                {{ $t('about.free.donate') }}
              </a>
            </p>
          </div>
          <!-- /.about--item -->
        </div>
        <!-- /.about-items -->
      </div>
      <!-- /.about -->
    </div>
    <!-- /.box -->
    <div class="screenshots-wrapper box fh">
      <img src="/img/mockup.webp" alt="">
    </div>
    <!-- /.screenshots-wrapper box fh -->
    <div class="stats" v-if="stats">
      <div class="box fh">
        <div class="stats-items">
          <div class="stats--item" v-for="(item, key) in stats" :key="key">
            <h3>{{ item }}</h3>
            <p>{{ $t('stats.' + key) }}</p>
          </div>
          <!-- /.stats--item -->
        </div>
        <!-- /.stats-items -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.stats -->
    <footer>
      <div class="box fh">
        <div class="footer">
          <div class="footer-text">
            <h3>WebDevHub</h3>
          </div>

          <div class="footer-social-icon">
            <a href="https://fb.me/webdevhub.official" target="_blank">
              <fa :icon="['fab', 'facebook']" />
            </a>
            <!-- @TODO: Add twitter & instagram links-->
            <!--<a href="#" target="_blank">-->
            <!--<fa :icon="['fab', 'twitter']" />-->
            <!--</a>-->
            <!--<a href="#" target="_blank">-->
            <!--<fa :icon="['fab', 'instagram']" />-->
            <!--</a>-->
            <a href="https://www.patreon.com/webdevhub" target="_blank">
              <fa :icon="['fab', 'patreon']" />
            </a>
          </div>
          <!--<div class="footer-menu">-->
          <!--<nav>-->
          <!--<ul>-->
          <!--<li>-->
          <!--<a href="#">-->
          <!--{{ $t('terms_conditions') }}-->
          <!--</a>-->
          <!--</li>-->
          <!--<li>-->
          <!--<a href="#">-->
          <!--{{ $t('privacy_policy') }}-->
          <!--</a>-->
          <!--</li>-->
          <!--<li>-->
          <!--<a href="#">-->
          <!--{{ $t('contact') }}-->
          <!--</a>-->
          <!--</li>-->
          <!--</ul>-->
          <!--</nav>-->
          <!--</div>-->

          <div class="copyright-text">
            <p>Copyright © 2019 WebDevHub</p>
          </div>
        </div>
        <!-- /.footer -->
      </div>
      <!-- /.box -->
    </footer>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  metaInfo () {
    return { title: this.$t('home') }
  },

  data: () => ({
    title: window.config.appName
  }),

  created () {
    this.$store.dispatch('global/getBaseStats')
  },

  computed: mapGetters({
    authenticated: 'auth/check',
    stats: 'global/stats'
  }),

  methods: {
    redirectUserToHome () {
      if (this.authenticated) {
        this.$router.push({ name: 'home' })
      }
    },
    scrollToAbout () {
      let top = this.$refs['about-section'].offsetTop
      console.log(top)
      window.scrollTo(0, top)
    }
  }
}
</script>

<style scoped lang="scss">
@import "../../css/animate.css";
.fh {
  height: auto;
}
h2 {
  font-weight: 300;
  color: #5b32b4;
  font-size: 48px;
  margin: 0 0 60px 0;
  position: relative;
  text-transform: capitalize;
  padding-bottom: 15px;
  &:after {
    content: '';
    width: 80px;
    height: 2px;
    background-color: #fb397d;
    position: absolute;
    left: 50%;
    bottom: 0;
    transform: translateX(-50%);
  }
}
#welcome {
  width: 100%;
  background-color: #ffffff;
}
.first-section-wrapper {
  height: calc(100vh - 81px);
  background-image: url("/img/welcome-bg.png");
  background-position: bottom center;
  background-size: cover;
  position: relative;
  z-index: 1;
  .first-section {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
  }
  h1 {
    color: #FFF;
    font-weight: bold;
    font-size: 50px;
    margin-bottom: 25px;
    text-align: center;
  }

  span {
    font-size: 32px;
    color: #fff;
  }
  button {
    background-color: #fb397d;
    border-radius: 24px;
    padding: 0 35px;
    height: 50px;
    text-align: center;
    font-size: 16px;
    color: #FFF;
    margin-top: 50px;
    position: relative;
    z-index: 0;
    &:hover {
      cursor: pointer;
      box-shadow: 0 1px 3px rgba(0,0,0,0.6);
    }
  }
}

.about-wrapper {
  position: relative;
  z-index: 1;
  background: #FFF;
  margin-bottom: 0;
  padding: 30px 0;
}
.about {
  width: 100%;
  h2 {
    text-align: center;
  }
  &-items {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    grid-column-gap: 20px;
    padding-bottom: 25px;
  }
  &--item {
    border: 1px solid #eff2f6;
    padding: 40px;
    border-radius: 40px 40px 40px 0;
    transition-duration: 800ms;
    text-align: center;
    &:hover {
      box-shadow: 0 10px 90px rgba(0,0,0,.08);
    }
    svg path {
      fill: #fb397d;
    }
    h4 {
      font-size: 22px;
      color: #5b32b4;
      margin-bottom: 15px;
    }
  }
}

.screenshots-wrapper {
  position: relative;
  z-index: 2;
  margin-bottom: 0;
  img {
    width: 75%;
    height: 100%;
    border: 20px solid #fff;
    border-radius: 20px;
    box-shadow: 0 10px 50px rgba(0, 0, 0, 0.08);
    margin: auto;
  }
}

.stats {
  background: linear-gradient(to left,#7873ed,#a865e1);
  box-shadow: rgba(0, 0, 0, 0.3) 0px 20px 30px -20px;
  padding: 180px 0 80px;
  margin-bottom: 268px;
  position: relative;
  z-index: 1;
  top: -100px;
  &-items {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr;
    grid-column-gap: 20px;
    width: 100%;
  }
  &--item {
    color: #FFF;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    h3 {
      font-size: 60px;
      margin: 0;
      font-weight: bold;
    }
    p {
      text-transform: uppercase;
    }
  }
}

footer {
  position: fixed;
  left: 0;
  bottom: 0;
  background-color: #FFF;
  width: 100%;
  z-index: 0;
  .footer {
    width: 100%;
    background: transparent;
    text-align: center;
    h3 {
      color: #5b32b4;
      font-size: 56px;
      font-weight: 700;
      margin-top: 0;
    }
  }
  .footer-menu ul li {
    display: inline-block;
    a {
      border-right: 2px solid #726a84;
      display: block;
      padding: 0 7.5px;
      color: #726a84;
      &:hover {
        color: #3c81e8;
      }
    }
    &:last-child a {
      border-right: 0 solid #ddd;
    }
  }
  .footer-social-icon {
    margin-bottom: 30px;
    a {
      background: #9b69e4;
      font-size: 14px;
      color: #fff;
      height: 40px;
      width: 40px;
      line-height: 40px;
      font-weight: 500;
      border-radius: 10px 10px 10px 0;
      margin-right: 10px;
      display: inline-block;
      &:hover {
        background: #fb397d;
      }
    }
  }
}

@media only screen and (min-width: 320px) and (max-width: 768px) {
  h1, h2, h3, span {
    text-align: center;
  }
  .first-section-wrapper {
    h1 {
      font-size: 36px;
    }
    span {
      font-size: 18px;
    }
  }
  .about-wrapper {
    margin: 0;
    padding: 30px 15px;
    width: 100%;
  }
  .about-items, .stats-items {
    grid-template-columns: 1fr;
    grid-row-gap: 20px;
  }
  .screenshots-wrapper img {
    width: 100%;
    border: 10px solid #FFF;
  }
  footer .footer-menu ul li a {
    border: none;
  }
}
</style>
