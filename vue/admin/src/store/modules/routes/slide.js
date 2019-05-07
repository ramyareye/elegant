export default {
  path: '/slides',
  name: 'slides-root',
  meta: {
    per: 'list-slides',
    title: 'menu.slides.slides'
  },
  children: [
    {
      name: 'slides',
      path: '/slides/all',    
      component: 'slides/index',
      meta: {
        userAuth: true,
        per: 'list-slides',      
        title: 'menu.slides.slides'
      }
    },
    {
      name: 'slide',
      path: '/slides/show/:id',
      component: 'slides/show',
      meta: {
        hidden: true,
        userAuth: true,
        per: 'list-slides',      
        title: 'menu.slides.slide'
      }
    },
    {
      name: 'create-slide',
      path: '/slides/create',    
      component: 'slides/create',
      meta: {
        userAuth: true,
        per: 'create-slides',      
        title: 'menu.slides.create'
      }
    },
    {
      name: 'update-slide',
      path: '/slides/update/:id',    
      component: 'slides/update',
      meta: {
        hidden: true,
        userAuth: true,
        per: 'update-slides',      
        title: 'menu.slides.update'
      }
    }
  ]
}
