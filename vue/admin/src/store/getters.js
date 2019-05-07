const config = state => state.app.config
const isLoading = state => state.app.isLoading
const palette = state => state.app.config.palette
const toggleWithoutAnimation = state => state.app.sidebar.withoutAnimation

const token = state => state.auth.token
const permissions = state => state.auth.permissions
const authenticated = state => state.auth.authenticated
const menuItems = state => state.routes.items
const breadcrumbs = state => state.routes.items

export {
  token,
  config,  
  palette,
  isLoading,
  menuItems,
  breadcrumbs,
  permissions,
  authenticated,
  toggleWithoutAnimation
}
