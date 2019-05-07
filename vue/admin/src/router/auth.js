import lazyLoading from './lazyLoading'
import AuthLayout from 'view/layout/AuthLayout'

export default [
  {
	  path: '/auth',
	  component: AuthLayout,
	  children: [
	    {
	      name: 'login',
	      path: 'login',
	      component: lazyLoading('auth/login'),
	      meta: {
		      userNotAuth: true
		    }
	    },
	    {
	      name: 'signup',
	      path: 'signup',
	      component: lazyLoading('auth/signup'),
	      meta: {
		      userNotAuth: true
		    }
	    },
	    {
	      path: '',
	      redirect: { name: 'login' },
	    },
	  ],
	}
]
