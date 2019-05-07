<template>
  <div class="row">
    <div class="col-md-12">
      <vuestic-widget class="no-padding no-v-padding">
        <vuestic-breadcrumbs :breadcrumbs="breadcrumbs" :current-path="currentRoute"/>
      </vuestic-widget>
    </div>
  </div>
</template>

<script>

export default {
  name: 'app-breadcrumbs',
  computed: {
    currentRoute () {
      return this.$route.name
    },
    breadcrumbs () {
      const breadcrumbs = this.$store.getters.breadcrumbs

      return breadcrumbs
    }
  }
}

</script>
