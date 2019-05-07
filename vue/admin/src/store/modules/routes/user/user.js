export default [
  {
    name: 'users',
    path: '/users/all',    
    component: 'users/user/index',
    meta: {
      userAuth: true,
      per: 'list-users',      
      title: 'menu.users.users'
    }
  },
  {
    name: 'user',
    path: '/users/show/:id',    
    component: 'users/user/show',
    meta: {
      hidden: true,
      userAuth: true,
      per: 'list-users',      
      title: 'menu.users.user'
    }
  },
  {
    name: 'create-user',
    path: '/users/create',    
    component: 'users/user/create',
    meta: {
      hidden: true,
      userAuth: true,
      per: 'create-users',      
      title: 'menu.users.create'
    }
  },
  {
    name: 'update-user',
    path: '/users/update/:id',    
    component: 'users/user/update',
    meta: {
      hidden: true,
      userAuth: true,
      per: 'update-users',      
      title: 'menu.users.update'
    }
  }
]
