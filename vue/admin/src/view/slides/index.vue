<template>
  <div>
    <vuestic-widget :headerText="'menu.slides.slides' | translate">
      <data-table
        :apiUrl="apiUrl"
        :columns="columns"
      />
    </vuestic-widget>
  </div>
</template>

<script>
  import Vue from 'vue'
  import Columns from './columns'
  import Actions from './actions'
  import DataTable from 'view/components/data-table'

  Vue.component('slide-custom-actions', Actions)

  export default {
    name: 'slides',
    components: {
      DataTable
    },
    data () {
      return {
        columns: Columns,
        apiUrl: '/api/slides'
      }
    }
  }
</script>
