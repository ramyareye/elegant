export default {
  path: '/posts',
  name: 'posts-root',
  meta: {
    per: 'list-posts',
    title: 'menu.posts.posts'
  },
  children: [
    {
      name: 'posts',
      path: '/posts/all',    
      component: 'posts/index',
      meta: {
        userAuth: true,
        per: 'list-posts',      
        title: 'menu.posts.posts'
      }
    },
    {
      name: 'post',
      path: '/posts/show/:id',
      component: 'posts/show',
      meta: {
        hidden: true,
        userAuth: true,
        per: 'list-posts',      
        title: 'menu.posts.post'
      }
    },
    {
      name: 'create-post',
      path: '/posts/create',    
      component: 'posts/create',
      meta: {
        userAuth: true,
        per: 'create-posts',      
        title: 'menu.posts.create'
      }
    },
    {
      name: 'update-post',
      path: '/posts/update/:id',    
      component: 'posts/update',
      meta: {
        hidden: true,
        userAuth: true,
        per: 'update-posts',      
        title: 'menu.posts.update'
      }
    }
  ]
}
