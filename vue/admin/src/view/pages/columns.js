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
      title: Vue.i18n.translate('page.title')
    },
    {
      name: 'slug',
      title: Vue.i18n.translate('post.slug')
    },
    {
      sortField: 'title',
      dataClass: 'text-center',
      name: 'created_at_persian',
      title: Vue.i18n.translate('vuetable.created_at')
    },
    {
      name: '__component:page-custom-actions',
      title: Vue.i18n.translate('vuetable.actions')
    }
  ]
}
