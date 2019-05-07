export default [
  {
    name: 'roles',
    path: '/roles/all',
    component: 'users/role/index',
    meta: {
      userAuth: true,
      per: 'list-roles',
      title: 'menu.roles.roles'
    }
  },
  {
    name: 'role',
    path: '/roles/show/:id',    
    component: 'users/role/show',
    meta: {
      hidden: true,
      userAuth: true,
      per: 'list-roles',
      title: 'menu.roles.role'
    }
  },
  {
    name: 'update-role',
    path: '/roles/update/:id',
    component: 'users/role/update',
    meta: {
      hidden: true,
      userAuth: true,
      per: 'update-roles',
      title: 'menu.roles.update'
    }
  }
]
