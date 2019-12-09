import Vue from 'vue'
import VueRouter from 'vue-router'
// import Start from './views/Start'
import NewsFeed from './views/NewsFeed'
import UserShow from './views/Users/Show'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'home',
    component: NewsFeed,
    meta: { title: 'News Feed' }
  },
  {
    path: '/users/:userId',
    name: 'user.show',
    component: UserShow,
    meta: { title: 'Profile' }
  },
]

export default new VueRouter({
  mode: 'history',
  routes,
})