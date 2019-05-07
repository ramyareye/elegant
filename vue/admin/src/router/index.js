import Vue from 'vue'
import Router from 'vue-router'

import store from 'vuex-store'

import lazyLoading from './lazyLoading'
import AppLayout from 'view/layout/AppLayout'
import AuthLayout from 'view/layout/AuthLayout'

import auth from './auth'

Vue.use(Router)

const EmptyParentComponent = {
  name: 'router',
  template: '<router-view></router-view>'
}

function lazyLoadComponent (item) {
  item.component = item.component ?
    lazyLoading(item.component) :
    EmptyParentComponent  

  if (item.children) {
    for (let i = 0, l = item.children.length; i < l; i++) {
      item.children[i].component = lazyLoading(item.children[i].component)
    }
  }

  return item
}

function generateRoutesFromMenu (menu = [], routes = []) {  
  for (let i = 0, l = menu.length; i < l; i++) {
    let item = menu[i]    
    if (item.path) {
      routes.push(lazyLoadComponent(item))
    }
    // if (item.children) {
    //   generateRoutesFromMenu(item.children, routes)
    // }
  }
  return routes
}

function getDefaultRoute (menu = []) {
  let defaultRoute

  menu.forEach((item) => {
    if (item.default) {
      defaultRoute = item
    } else if (item.children) {
      let defaultChild = item.children.find((i) => i.default)
      defaultRoute = defaultChild || defaultRoute
    }
  })

  return defaultRoute
}

export default new Router({
  routes: [
    {
      path: '*',
      redirect: { name: getDefaultRoute(store.getters.menuItems).name }
    },

    ...auth,
    
    {
      name: 'backend',
      path: '/backend',
      component: AppLayout,
      children: [
        ...generateRoutesFromMenu(JSON.parse(JSON.stringify(store.getters.menuItems)))
      ]
    }
  ]
})
