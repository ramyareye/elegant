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
      name: 'name',
      title: Vue.i18n.translate('role.name')
    },
    {
      name: '__component:role-custom-actions',
      title: Vue.i18n.translate('vuetable.actions')
    }
  ]
}
