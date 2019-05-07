export default {
  path: '/pages',
  name: 'pages-root',
  meta: {
    per: 'list-pages',
    title: 'menu.pages.pages'
  },
  children: [
    {
      name: 'pages',
      path: '/pages/all',    
      component: 'pages/index',
      meta: {
        userAuth: true,
        per: 'list-pages',      
        title: 'menu.pages.pages'
      }
    },
    {
      name: 'page',
      path: '/pages/show/:id',
      component: 'pages/show',
      meta: {
        hidden: true,
        userAuth: true,
        per: 'list-pages',      
        title: 'menu.pages.page'
      }
    },
    {
      name: 'create-page',
      path: '/pages/create',    
      component: 'pages/create',
      meta: {
        userAuth: true,
        per: 'create-pages',      
        title: 'menu.pages.create'
      }
    },
    {
      name: 'update-page',
      path: '/pages/update/:id',    
      component: 'pages/update',
      meta: {
        hidden: true,
        userAuth: true,
        per: 'update-pages',      
        title: 'menu.pages.update'
      }
    }
  ]
}
