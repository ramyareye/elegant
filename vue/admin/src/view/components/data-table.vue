<template>
  <vuestic-table
    @initialized="init"
    :apiUrl="apiUrl"
    :apiMode="apiMode"
    :httpOptions="httpOptionsData()"
    :queryParams="queryParams"
    :paginationPath="paginationPath"
    :tableFields="columns.tableFields"
    :filterInputLabel="filterInputLabel"
    :sortFunctions="columns.sortFunctions"    
    :itemsPerPageLabel="itemsPerPageLabel"
    :itemsPerPage="itemsPerPage"
  />
</template>

<script>
  import Vue from 'vue'
  import BadgeColumn from 'partials/BadgeColumn.vue'
  import VuesticTable from 'view/components/data-table/vuestic-table'
  import QueryParams from 'vuestic-components/vuestic-datatable/data/query-params'

  Vue.component('badge-column', BadgeColumn)

  export default {
    name: 'data-table',
    props: {
	    apiUrl: {
	      type: String,
      	required: true
	    },
	    columns: {
	      type: Object,
      	required: true
	    },
      httpOptions: {
        type: Object,
        default () {
          return {}
        }
      },
      paginationPath: {
        type: String,
        default: 'meta.pagination'
      },
      filterInputLabel: {
        type: String,
        default: Vue.i18n.translate('vuetable.search')
      },
      itemsPerPage: {
        type: Array,
        default: () => [
          {
            value: 10
          },
          {
            value: 25
          }
        ]
      }
	  },
    components: {
      'vuestic-table': VuesticTable
    },

    data () {
      return {
        apiMode: true,
        datatable: {},
        queryParams: QueryParams,
        itemsPerPageLabel: Vue.i18n.translate('vuetable.perpage')
      }
    },
    methods: {
      httpOptionsData () {
        if (
          Object.keys(this.httpOptions).length === 0 
          && this.httpOptions.constructor === Object
        ) {
          const token = this.$store.getters.token

          return { headers: { Authorization: `Bearer ${token}` } }
        } else {
          return {}          
        }
      },
      init (ref) {
        this.datatable = ref

        this.$emit('initialized', ref)
      }
    },
    beforeDestroy () {
      // console.log([1, this])
    }
  }
</script>

<style lang="scss">
  .color-icon-label-table {
    td:first-child {
      width: 1rem;
    }
  }
</style>
