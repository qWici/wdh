// const Welcome = () => import('~/pages/welcome').then(m => m.default || m)
const Login = () => import('~/pages/auth/login').then(m => m.default || m)
const Register = () => import('~/pages/auth/register').then(m => m.default || m)
const PasswordEmail = () => import('~/pages/auth/password/email').then(m => m.default || m)
const PasswordReset = () => import('~/pages/auth/password/reset').then(m => m.default || m)
const NotFound = () => import('~/pages/errors/404').then(m => m.default || m)

// TermsAndConditions && PP
const TermsAndConditions = () => import('~/pages/terms-and-conditions').then(m => m.default || m)
const PrivacyPolicy = () => import('~/pages/privacy-policy').then(m => m.default || m)

const Home = () => import('~/pages/home').then(m => m.default || m)
const Bookmarks = () => import('~/pages/bookmarks').then(m => m.default || m)

const StreamIndex = () => import('~/pages/stream/index').then(m => m.default || m)
const StreamList = () => import('~/pages/stream/list').then(m => m.default || m)
const StreamTag = () => import('~/pages/stream/tag').then(m => m.default || m)
const StreamSingle = () => import('~/pages/stream/single').then(m => m.default || m)

const ArticleIndex = () => import('~/pages/articles/index').then(m => m.default || m)
const ArticleList = () => import('~/pages/articles/list').then(m => m.default || m)
const ArticleAuthor = () => import('~/pages/articles/author').then(m => m.default || m)
const ArticleAuthors = () => import('~/pages/articles/authors').then(m => m.default || m)
const ArticleSingle = () => import('~/pages/articles/single').then(m => m.default || m)

const VideoIndex = () => import('~/pages/videos/index').then(m => m.default || m)
const VideosList = () => import('~/pages/videos/list').then(m => m.default || m)
const VideoChannel = () => import('~/pages/videos/channel').then(m => m.default || m)
const VideoSingle = () => import('~/pages/videos/single').then(m => m.default || m)

const PodcastsIndex = () => import('~/pages/podcasts/index').then(m => m.default || m)
const PodcastsList = () => import('~/pages/podcasts/list').then(m => m.default || m)
const PodcastShow = () => import('~/pages/podcasts/show').then(m => m.default || m)
const PodcastSingle = () => import('~/pages/podcasts/single').then(m => m.default || m)

const Settings = () => import('~/pages/settings/index').then(m => m.default || m)
const SettingsProfile = () => import('~/pages/settings/profile').then(m => m.default || m)
const SettingsPassword = () => import('~/pages/settings/password').then(m => m.default || m)

export default [
  { path: '', name: 'home', component: Home },

  { path: '/login', name: 'login', component: Login },
  { path: '/register', name: 'register', component: Register },
  { path: '/terms-and-conditions', name: 'terms-and-conditions', component: TermsAndConditions },
  { path: '/privacy-policy', name: 'privacy-policy', component: PrivacyPolicy },
  { path: '/password/reset', name: 'password.request', component: PasswordEmail },
  { path: '/password/reset/:token', name: 'password.reset', component: PasswordReset },

  // { path: '/home', name: 'home', component: Home },
  { path: '/authors', name: 'authors', component: ArticleAuthors },
  { path: '/bookmarks', name: 'bookmarks', component: Bookmarks },

  {
    path: '/streams',
    component: StreamIndex,
    children: [
      { path: '', name: 'stream', component: StreamList },
      { path: ':id/', name: 'stream.single', component: StreamSingle },
      { path: 'tag/:id/', name: 'stream.tag', component: StreamTag }
    ]
  },

  {
    path: '/articles',
    component: ArticleIndex,
    children: [
      { path: '', name: 'article', component: ArticleList },
      { path: ':author/', name: 'article.author', component: ArticleAuthor },
      { path: ':author/:slug/', name: 'article.single', component: ArticleSingle }
    ]
  },

  {
    path: '/videos',
    component: VideoIndex,
    children: [
      { path: '', name: 'video', component: VideosList },
      { path: ':channel/', name: 'video.channel', component: VideoChannel },
      { path: ':channel/:slug/', name: 'video.single', component: VideoSingle }
    ]
  },

  {
    path: '/podcasts',
    component: PodcastsIndex,
    children: [
      { path: '', name: 'podcast', component: PodcastsList },
      { path: ':show/', name: 'podcast.show', component: PodcastShow },
      { path: ':show/:slug/', name: 'podcast.single', component: PodcastSingle }
    ]
  },

  { path: '/settings',
    component: Settings,
    children: [
      { path: '', redirect: { name: 'settings.profile' } },
      { path: 'profile', name: 'settings.profile', component: SettingsProfile },
      { path: 'password', name: 'settings.password', component: SettingsPassword }
    ]
  },

  { path: '*', name: '404', component: NotFound }
]
