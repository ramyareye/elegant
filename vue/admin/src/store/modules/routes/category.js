export default {	
	path: 'categories',
  name: 'categories-root',
  meta: {
    userAuth: true,
    per: 'list-categories',      
    title: 'menu.categories.categories'
  },
  children: [
  	{
      name: 'categories',
      path: 'all/:id?/:parent?',    
      component: 'categories/index',
      meta: {
        userAuth: true,
        per: 'list-categories',      
        title: 'menu.categories.categories'
      }
    },
  	{
	    name: 'category',
	    path: 'show/:id',
	    component: 'categories/show',
	    meta: {
	      hidden: true,
	      userAuth: true,
	      per: 'list-categories',      
	      title: 'menu.categories.category'
	    }
	  },
	  {
	    name: 'create-category',
	    path: 'create/:parent?',    
	    component: 'categories/create',
	    meta: {
	      hidden: true,
	      userAuth: true,
	      per: 'create-categories',      
	      title: 'menu.categories.create'
	    }
	  },
	  {
	    name: 'update-category',
	    path: 'update/:id',    
	    component: 'categories/update',
	    meta: {
	      hidden: true,
	      userAuth: true,
	      per: 'update-categories',      
	      title: 'menu.categories.update'
	    }
	  }
	]
}