<template>
  <div class="admin-custom-actions text-center">
    <i class="glyphicon glyphicon-zoom-in" @click="show()"></i>
    <i class="glyphicon glyphicon-pencil" @click="edit()"></i>
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
      this.$router.push({ name: 'admin', params: { id } })
    },
    edit (data) {
      const id = this.rowData.id
      this.$router.push({ name: 'update-admin', params: { id } })
    }
  }
}
</script>