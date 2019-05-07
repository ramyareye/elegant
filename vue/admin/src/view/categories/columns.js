import Vue from 'vue'

export default {
  tableFields: [
    {
      name: '__component:badge-column',
      title: '',
      dataClass: 'text-center'
    },
    {
      name: 'name',
      title: Vue.i18n.translate('category.name')
    },
    {
      sortField: 'title',
      dataClass: 'text-center',
      name: 'created_at_persian',
      title: Vue.i18n.translate('vuetable.created_at')
    },
    {
      name: '__component:category-custom-actions',
      title: Vue.i18n.translate('vuetable.actions')
    }
  ]
}
