<template>
  <div class="widget-body">
    <loading v-if="!loaded"/>
    <div class="row" v-else>
      <vuestic-widget class="col" :headerText="render_title()">
        <div class="row show-buttons-area">
          <router-link
            :to="{ name: 'posts' }"
            class="btn btn-info btn-micro"
          >
            {{'menu.posts.posts' | translate}}
          </router-link>
          <router-link 
            v-if="id"              
            class="btn btn-primary btn-micro"
            :to="{ name: 'update-post', params: { id: this.id } }"
          >
            {{'buttons.update' | translate}}
          </router-link>
        </div>

        <div class="row">
          <ul class="vue-unordered">
            <li>
              {{'menu.categories.categories' | translate}} :

              <ul class="vue-list-inner">
                <li v-for="category in categories">
                  {{ category.title }}
                </li>
              </ul>
            </li>
          </ul>
        </div>

        <div class="row vue-misc well" v-html="post.excerpt"></div>

        <div class="row vue-misc well" v-html="post.body"></div>

      </vuestic-widget>
    </div>
  </div>
</template>

<script>
  import Vue from 'vue'
  import api from 'src/packages/Api'
  import Loading from 'partials/Loading'

  Vue.component('loading', Loading)

  export default {
    name: 'post',
    data () {
      return {
        post: {},
        id: '',
        body: '',
        title: '',
        excerpt: '',        
        categories: [],
        loaded: false
      }
    },
    created () {
      api.get(`posts/${this.$route.params.id}`).then(response => {
        const res = response.data

        this.post = res
        this.id = res.id
        this.body = res.body
        this.title = res.title
        this.excerpt = res.excerpt
        this.visible = res.visible        

        this.categories = res.categories.data

        this.loaded = true
      }).catch(error => {
        this.$store.dispatch('addToastMessage',
          { text: Vue.i18n.translate(`errors.${error.data.status_code}`) }
        )
        this.$router.push({ name: 'posts' })
      })
    },
    methods: {
      render_title () {
        return `${this.post.title} / ${this.post.visible ? 
          Vue.i18n.translate('post.visible_yes') :
          Vue.i18n.translate('post.visible_no')}`
      }
    }
  }
</script>

<style lang="scss">
</style>
