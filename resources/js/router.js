import Vue from 'vue'
import VueRouter from 'vue-router'
import Start from './views/Start'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'home',
    component: Start
  }
]

export default new VueRouter({
  mode: 'history',
  routes,
})