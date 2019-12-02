import Vue from 'vue'
import VueRouter from 'vue-router'
// import Start from './views/Start'
import NewsFeed from './views/NewsFeed'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'home',
    component: NewsFeed
  },
]

export default new VueRouter({
  mode: 'history',
  routes,
})