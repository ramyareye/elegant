<script>
  import Vue from 'vue'
  import Columns from './columns'
  import Actions from './actions'
  import api from 'src/packages/Api'
  import DataTable from 'view/components/data-table'

  Vue.component('category-custom-actions', Actions)

  export default {
    name: 'categories',
    components: {
      DataTable
    },
    data () {
      return {        
        datatable: {},
        columns: Columns,
        itemsPerPage: [{ value: 100 }]
      }
    },
    computed: {
      apiUrl () {
        return `/api/categories${ 
            this.$route.params.id 
              ? '?id=' + this.$route.params.id 
              : ''
          }`
      },
      backParams () {
        const parent = this.$route.params.parent
        const params = parent ? { id: parent } : {}

        return params
      },
      createParams () {
        const params = this.$route.params.id 
          ? { parent : this.$route.params.id } 
          : {}

        return params
      }
    },
    methods: {
      up (id) {
        api.post(`categories/up/${id}`).then(response => {
          this.datatable.refresh()
        }).catch(error => {
          // console.log(['e', e])
        })
      },
      down (id) {
        api.post(`categories/down/${id}`).then(response => {
          this.datatable.refresh()
        }).catch(error => {
          // console.log([ 'e', e])
        })
      },
      init (ref) {
        this.datatable = ref
      }
    }
  }
</script>

<template>
  <div>
    <vuestic-widget :headerText="'menu.categories.categories' | translate">
      <div class="row" v-if="this.$route.params.id">
        <div class="col">                  
          <router-link
            :to="{ name: 'categories', params: backParams }"
            class="btn btn-warning btn-micro"
          >
            {{'buttons.back' | translate}}
          </router-link>
        </div>
      </div>

      <data-table
        @up="up"
        @down="down"
        :apiUrl="apiUrl"
        :columns="columns"
        @initialized="init"
        :paginationPath="''"
        :itemsPerPage="itemsPerPage"
      />

      <div class="row">
        <div class="col text-center">                  
          <router-link
            :to="{ name: 'create-category', params: createParams }"
            class="btn btn-success btn-micro"
          >
            {{'menu.categories.create' | translate}}
          </router-link>
        </div>
      </div>
    </vuestic-widget>
  </div>
</template>
