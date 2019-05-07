<template>
  <div class="widget-body">
    <loading v-if="!loaded"/>
    <div class="row" v-else>
      <vuestic-widget class="col" :headerText="category.name">
        <div class="row show-buttons-area">
          <router-link
            :to="{ name: 'categories' }"
            class="btn btn-info btn-micro"
          >
            {{'menu.categories.categories' | translate}}
          </router-link>
          <router-link 
            class="btn btn-primary btn-micro"
            :to="{ name: 'update-category', params: { id: category.id } }"
          >
            {{'buttons.update' | translate}}
          </router-link>
        </div>

        <div class="row vue-misc well" v-html="category.description"></div>

        <div class="row">
          {{ 'custom.parent' | translate }} : 
          {{ category.parent_id ? parent.name : 'custom.no_parent' | translate }}
        </div>
      </vuestic-widget>
    </div>
  </div>
</template>

<script>
  import api from 'src/packages/Api'
  import Loading from 'partials/Loading'

  export default {
    name: 'category',
    data () {
      return {
        category: {},
        parent: {},

        loaded: false
      }
    },
    components: {
      Loading
    },
    created () {
      api.get(`categories/${this.$route.params.id}`).then(response => {
        const res = response.data
        
        this.category = res
        this.parent = res.parent_id ? res.parent.data : {}

        this.loaded = true
      }).catch(error => {
        this.$store.dispatch('addToastMessage',
          { text: this.$t(`errors.${error.data.status_code}`) }
        )
        this.$router.push({ name: 'categories' })
      })
    }
  }
</script>
