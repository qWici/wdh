import Vue from 'vue'
import LogRocket from 'logrocket'
import * as Sentry from '@sentry/browser'
import * as Integrations from '@sentry/integrations'

if (process.env.NODE_ENV !== 'development') {
  LogRocket.getSessionURL(sessionURL => {
    Sentry.configureScope(scope => {
      scope.setExtra('sessionURL', sessionURL)
    })
  })

  Sentry.init({
    dsn: 'https://6f65ee400b294a13ab0b4c8ccbb92e3b@sentry.io/1412774',
    integrations: [
      new Integrations.Vue({ Vue, attachProps: true })
    ]
  })
}
