<template>
  <div class="widget-body">
    <loading v-if="!loaded"/>
    <div class="row" v-else>
      <div class="col">
        <vuestic-widget :headerText="slide.title">

          <div class="row show-buttons-area">
            <router-link
              :to="{ name: 'slides' }"
              class="btn btn-info btn-micro"
            >
              {{'menu.slides.slides' | translate}}
            </router-link>
            <router-link 
              v-if="id"              
              class="btn btn-primary btn-micro"
              :to="{ name: 'update-slide', params: { id: this.id } }"
            >
              {{'buttons.update' | translate}}
            </router-link>
          </div>

          <div class="row cover-img" v-if="slide.image">
            <img :src="slide.image.data.url.main" />
          </div>
          <div v-else></div>

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
    name: 'slide',
    data () {
      return {
        slide: {},
        id: '',
        title: '',
        order: '',

        loaded: false
      }
    },
    created () {
      api.get(`slides/${this.$route.params.id}`).then(response => {
        const res = response.data

        this.slide = res
        this.id = res.id
        this.title = res.title
        this.order = res.order

        this.loaded = true
      }).catch(error => {
        this.$store.dispatch('addToastMessage',
          { text: Vue.i18n.translate(`errors.${error.data.status_code}`) }
        )
        this.$router.push({ name: 'slides' })
      })
    },
    methods: {
      containsKey(obj, key ) {
          return Object.keys(obj).includes(key);
      }
    },
    computed: {
      hasImage() {
          return this.containsKey(this.slide, 'image');
      }
    }
  }
</script>

<style lang="scss">
  .cover-img {
    text-align: center;
  }

  .cover-img img {
    margin: 30px auto;
    max-height: 300px;
    border: 10px solid #7cdb8c;
  }
</style>
