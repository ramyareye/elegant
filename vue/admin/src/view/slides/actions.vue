<template>
  <div class="slide-custom-actions text-center">
    <i class="glyphicon glyphicon-zoom-in" @click="show()"></i>
    <i class="glyphicon glyphicon-pencil" @click="edit()"></i>
  </div>
</template>

<script>
export default {
  name: 'slide-actions',
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
      this.$router.push({ name: 'slide', params: { id } })
    },
    edit (data) {
      const id = this.rowData.id
      this.$router.push({ name: 'update-slide', params: { id } })
    }
  }
}
</script>