<template>
  <div class="widget-body">
    <loading v-if="!loaded"/>
    <div class="row" v-else>
      <div class="col">
        <vuestic-widget :headerText="page.title">

          <div class="row show-buttons-area">
            <router-link
              :to="{ name: 'pages' }"
              class="btn btn-info btn-micro"
            >
              {{'menu.pages.pages' | translate}}
            </router-link>
            <router-link 
              v-if="id"              
              class="btn btn-primary btn-micro"
              :to="{ name: 'update-page', params: { id: this.id } }"
            >
              {{'buttons.update' | translate}}
            </router-link>

            <a class="btn btn-info btn-micro">
              {{ 
                page.visible
                  ? $t('page.visible_yes')
                  : $t('page.visible_no')
              }}
            </a>
          </div>

          <div class="row">
            <div class="col vue-misc well" v-html="excerpt"></div>
          </div>

          <div class="row">
            <div class="col vue-misc well" v-html="body"></div>
          </div>

        </vuestic-widget>
      </div>
    </div>
  </div>
</template>

<script>
  import Vue from 'vue'
  import api from 'src/packages/Api'
  import Loading from 'partials/Loading'

  Vue.component('loading', Loading)

  export default {
    name: 'page',
    data () {
      return {
        page: {},
        id: '',
        title: '',
        description: '',
        properties: '',
        conditions: '',
        province: '',
        city: '',
        image: '',
        cover: '',
        categories: [],
        places: [],
        equipments: [],
        coaches: [],
        guides: [],
        tags: [],
        loaded: false
      }
    },
    created () {
      api.get(`pages/${this.$route.params.id}`).then(response => {
        const res = response.data

        this.page = res
        this.id = res.id
        this.title = res.title
        this.slug = res.slug
        this.excerpt = res.excerpt
        this.body = res.body

        this.loaded = true
      }).catch(error => {
        this.$store.dispatch('addToastMessage',
          { text: Vue.i18n.translate(`errors.${error.data.status_code}`) }
        )
        this.$router.push({ name: 'pages' })
      })
    }
  }
</script>

<style lang="scss">
  .cover-img {
    text-align: center;
  }

  .cover-img img {
    max-height: 300px;
    border: 10px solid #7cdb8c;
    margin-bottom: 30px;
  }
</style>
