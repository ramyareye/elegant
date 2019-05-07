import Vue from 'vue'
import axios from 'axios'

import store from 'vuex-store'

const client = axios.create({
  baseURL: '/api/',
  json: true
})

client.interceptors.request.use(config => {
  const token = store.getters.token

  if(token) {
  	config.headers.Authorization = `Bearer ${token}`
  }
  return config
}, err => Promise.reject(err) )

client.interceptors.response.use(res => res, 
	error => {
	  switch (error.response.status) {
	    case 401:
	      store.dispatch('addToastMessage', { text: Vue.i18n.translate('errors.401'), type: 'error' })
	      store.dispatch('changeRoute', {to: 'login'})
	      break
	    case 403:
	      store.dispatch('addToastMessage', { text: Vue.i18n.translate('errors.403'), type: 'error' })
	      store.dispatch('changeRoute', {to: 'dashboard'})
        break
	    default:
	      break
	  }
	  
	  return Promise.reject(error)
	}
)

const call = async (method = 'get', url = '', data = {}) => {
	try {
    const response = await client({
      url,
      data,
      method
    })

    return Promise.resolve(response.data)
  } catch (error) {
  	return Promise.reject(error.response)
  }
}

const Api = {
	get: (url, guest, data) => call('get', url, guest, data),
  put: (url, guest, data) => call('put', url, guest, data),
  post: (url, guest, data) => call('post', url, guest, data),
  patch: (url, guest, data) => call('patch', url, guest, data),
  delete: (url, guest, data) => call('delete', url, guest, data)
}

export default Api
