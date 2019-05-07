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
      title: `${Vue.i18n.translate('user.name')} ${Vue.i18n.translate('user.family')}`
    },
    {
      name: 'email',
      title: Vue.i18n.translate('user.email')
    },
    {
      dataClass: 'text-center',
      name: 'created_at_persian',
      title: Vue.i18n.translate('vuetable.created_at')
    },
    {
      name: '__component:user-custom-actions',   // <----
      title: Vue.i18n.translate('vuetable.actions')
    }
  ]
}
