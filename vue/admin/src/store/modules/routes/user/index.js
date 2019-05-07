import role from './role'
import user from './user'
import admin from './admin'

export default {
  path: '/users',
  name: 'users-root',
  meta: {
    per: 'list-users:list-consultants:list-users:list-roles',
    title: 'menu.users.users',
    iconClass: 'vuestic-icon vuestic-icon-user'
  },
  children: [
    ...role,
    ...user,
    ...admin
  ]
}
