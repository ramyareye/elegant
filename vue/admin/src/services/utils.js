export default {
  default: {
    root: {
      name: 'dashboard',
      displayName: 'menu.dashboard'
    },
    routes: []
  },

  manageBreadcrumbs (data, name) {
    const array = data.map(item => {
      let res = {}

      res.name = item.name
      res.displayName = item.meta ? item.meta.title : item.displayName      

      if (item.children) {
        const children = item.children.map(child => {
          return {
            name: child.name,
            displayName: child.meta.title
          }
        })

        res.children = children
      }

      return res
    })

    for (let i = 0; i < array.length; i++) {
      if (array[i].name === name) return [{ ...array[i] }]

      if (!array[i].children) continue

      let a = this.manageBreadcrumbs(array[i].children, name)
      if (a != null) {
        a.unshift(array[i])
        return [...a]
      }
    }

    return null
  },


  findInNestedByName (data, name) {
    this.default.routes = this.manageBreadcrumbs(data, name)

    return this.default
  }
}
