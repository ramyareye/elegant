<template>
  <div class="user-custom-actions text-center">
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
      this.$router.push({ name: 'user', params: { id } })
    },
    edit (data) {
      const id = this.rowData.id
      this.$router.push({ name: 'update-user', params: { id } })
    }
  }
}
</script>