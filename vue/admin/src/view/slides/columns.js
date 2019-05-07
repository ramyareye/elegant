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
      title: Vue.i18n.translate('slide.title')
    },
    {
      sortField: 'title',
      dataClass: 'text-center',
      name: 'created_at_persian',
      title: Vue.i18n.translate('vuetable.created_at')
    },
    {
      name: '__component:slide-custom-actions',
      title: Vue.i18n.translate('vuetable.actions')
    }
  ]
}
