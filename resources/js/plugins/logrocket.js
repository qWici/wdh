import LogRocket from 'logrocket'

if (process.env.NODE_ENV !== 'development') {
  LogRocket.init('iyqr8f/wdh-prod')
}
