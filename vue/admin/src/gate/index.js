import api from './api'

const methods = {
  get: (url, guest = [], data = {}) => api.get(url, guest, data),  
  put: (url, guest = [], data = {}) => api.put(url, guest, data),
  post: (url, guest = [], data = {}) => api.post(url, guest, data),
  patch: (url, guest = [], data = {}) => api.patch(url, guest, data),
  delete: (url, guest = [], data = {}) => api.delete(url, guest, data)
}

const auth = {
  signOut: () => api.signOut(),
  checkUser: () => api.get('get/check/user'),

  signIn: (data) => api.sign('in', data),
  signUp: (data) => api.sign('up', data),  

  signInConfirmation: (data) => api.sign('inConf', data),
  signUpConfirmation: (data) => api.sign('upConf', data)
}


export default {
  home: () => api.get('/home', ['guest'])

  ...methods,
  ...auth
}
