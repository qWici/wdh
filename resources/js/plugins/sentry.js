import Vue from 'vue'
import * as Sentry from '@sentry/browser'

Sentry.init({
  dsn: 'https://7c073845327440288818f593adbff883@sentry.io/1356292',
  integrations: [new Sentry.Integrations.Vue({
    Vue,
    attachProps: true
  })]
})
