const Welcome = () => import('~/pages/welcome').then(m => m.default || m)
const Login = () => import('~/pages/auth/login').then(m => m.default || m)
const Register = () => import('~/pages/auth/register').then(m => m.default || m)
const PasswordEmail = () => import('~/pages/auth/password/email').then(m => m.default || m)
const PasswordReset = () => import('~/pages/auth/password/reset').then(m => m.default || m)
const NotFound = () => import('~/pages/errors/404').then(m => m.default || m)

const Home = () => import('~/pages/home').then(m => m.default || m)

const StreamList = () => import('~/pages/stream/list').then(m => m.default || m)
const StreamTag = () => import('~/pages/stream/tag').then(m => m.default || m)
const StreamSingle = () => import('~/pages/stream/single').then(m => m.default || m)

const ArticleList = () => import('~/pages/articles/list').then(m => m.default || m)
const ArticleAuthor = () => import('~/pages/articles/author').then(m => m.default || m)
const ArticleSingle = () => import('~/pages/articles/single').then(m => m.default || m)

const VideosList = () => import('~/pages/videos/list').then(m => m.default || m)
const VideoSingle = () => import('~/pages/videos/single').then(m => m.default || m)

const Settings = () => import('~/pages/settings/index').then(m => m.default || m)
const SettingsProfile = () => import('~/pages/settings/profile').then(m => m.default || m)
const SettingsPassword = () => import('~/pages/settings/password').then(m => m.default || m)
// @TODO: Add tab for feedback

export default [
  { path: '/', name: 'welcome', component: Welcome },

  { path: '/login', name: 'login', component: Login },
  { path: '/register', name: 'register', component: Register },
  { path: '/password/reset', name: 'password.request', component: PasswordEmail },
  { path: '/password/reset/:token', name: 'password.reset', component: PasswordReset },

  { path: '/home', name: 'home', component: Home },

  { path: '/streams', name: 'streams', component: StreamList },
  { path: '/stream/:id', name: 'stream', component: StreamSingle },
  { path: '/stream/tag/:id', name: 'stream.tag', component: StreamTag },

  { path: '/articles', name: 'articles', component: ArticleList },
  { path: '/article/:author', name: 'article.author', component: ArticleAuthor },
  { path: '/article/:author/:slug', name: 'article', component: ArticleSingle },

  { path: '/videos', name: 'videos', component: VideosList },
  { path: '/video/:channel/:slug', name: 'video', component: VideoSingle },

  { path: '/settings',
    component: Settings,
    children: [
      { path: '', redirect: { name: 'settings.profile' } },
      { path: 'profile', name: 'settings.profile', component: SettingsProfile },
      { path: 'password', name: 'settings.password', component: SettingsPassword }
    ] },

  { path: '*', component: NotFound }
]
