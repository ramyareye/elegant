<template>
  <div class="category-custom-actions text-center">
    <i class="glyphicon glyphicon-chevron-up" @click="up()"></i>
    <i class="glyphicon glyphicon-chevron-down" @click="down()"></i>
    <i class="glyphicon glyphicon-zoom-in" @click="show()"></i>
    <i class="glyphicon glyphicon-pencil" @click="edit()"></i>
    <i class="glyphicon glyphicon-list" @click="children()"></i>    
  </div>
</template>

<script>
export default {
  props: {
    rowData: {
      type: Object,
      required: true
    },
    rowIndex: {
      type: Number
    }
  },
  methods: {
    show () {
      const id = this.rowData.id
      this.$router.push({ name: 'category', params: { id } })
    },
    edit () {
      const id = this.rowData.id
      this.$router.push({ name: 'update-category', params: { id } })
    },
    children () {
      const id = this.rowData.id
      const parent = this.rowData.parent_id

      this.$router.replace({ 
        name: 'categories', 
        params: { 
          id,
          parent
        }
      })
    },
    up () {
      const id = this.rowData.id
      this.$parent.$parent.$parent.$emit('up', id)
    },
    down () {
      const id = this.rowData.id
      this.$parent.$parent.$parent.$emit('down', id)
    },
  }
}
</script>
