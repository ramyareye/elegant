import Vue from 'vue'
// import moment from 'moment'

export default {
  tableFields: [
    {
      name: '__component:badge-column',
      title: '',
      dataClass: 'text-center'
    },
    {
      name: 'title',
      title: Vue.i18n.translate('post.title')
    },    
    {
      dataClass: 'text-center',
      name: 'categories.data.name',
      title: Vue.i18n.translate('post.categories')
    },
    {
      sortField: 'title',
      dataClass: 'text-center',
      name: 'created_at_persian',
      title: Vue.i18n.translate('vuetable.created_at')
    },
    {
      name: '__component:post-custom-actions',
      title: Vue.i18n.translate('vuetable.actions')
    }
  ]
}
