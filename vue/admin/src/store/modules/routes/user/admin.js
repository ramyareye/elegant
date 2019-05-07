export default [
  {
    name: 'admins',
    path: '/admins/all',    
    component: 'users/admin/index',
    meta: {
      userAuth: true,
      per: 'list-admins',      
      title: 'menu.admins.admins'
    }
  },
  {
    name: 'admin',
    path: '/admins/show/:id',
    component: 'users/admin/show',
    meta: {
      hidden: true,
      userAuth: true,
      per: 'list-admins',      
      title: 'menu.admins.admin'
    }
  },
  {
    name: 'create-admin',
    path: '/admins/create',    
    component: 'users/admin/create',
    meta: {
      hidden: true,
      userAuth: true,
      per: 'create-admins',      
      title: 'menu.admins.create'
    }
  },
  {
    name: 'update-admin',
    path: '/admins/update/:id',    
    component: 'users/admin/update',
    meta: {
      hidden: true,
      userAuth: true,
      per: 'update-admins',      
      title: 'menu.admins.update'
    }
  }
]
