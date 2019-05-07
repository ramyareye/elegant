<script>
  import api from 'src/packages/Api'
  import Loading from 'partials/Loading'
  import Uploader from 'view/components/uploader'
  
  export default {
    name: 'update-slide',
    data () {
      return {
        slide: {},

        id: 0,
        url: '',
        title: '',
        order: '',        
        site: true,

        loaded: false,
        apiUrl: 'slides/' + this.$route.params.id + "/upload/image",
        mobileApiUrl: 'slides/' + this.$route.params.id + "/upload/mobile",
      }
    },
    components: {
      Loading,
      Uploader
    },
    
    async created () {
      try {
        const request = await api.get(`slides/${this.$route.params.id}`)

        this.slide = request.data
        this.id = request.data.id
        this.url = request.data.url
        this.title = request.data.title
        this.order = request.data.order
        this.site = request.data.site ? true : false

        this.loaded = true
      } catch(error) {
        this.$store.dispatch('addToastMessage',
          { text: this.$t(`errors.${error.data.status_code}`) }
        )
        this.$router.push({ name: 'slides' })
      }
    },
    methods: {
      getImage () {
        const image = this.slide.image
          ? [this.slide.image.data] 
          : []
          
        return image
      },

      getMobile () {
        const mobile = this.slide.mobile
          ? [this.slide.mobile.data] 
          : []
          
        return mobile
      },

      reInitImage (response) {
        this.slide = response.data
      },

      update () {
        this.$validator.validateAll().then((result) => {
          if (result) {
            const data = {
              url: this.url,
              title: this.title,
              order: this.order,
              site: this.site ? 1 : 0
            }

            api.put(`slides/${this.id}`, data).then(response => {
              this.$store.dispatch('addToastMessage',
                { text: this.$t('slide.updated'), type: 'success' }
              )
              this.$router.push({ name: 'slide', params: { id: response.data.id } })
            }).catch(error => {
              this.$store.dispatch('addToastMessage',
                { text: this.$t('errors.any'), error }
              )
            })
          }
        })
      }
    }
  }
</script>

<template>
  <loading v-if="!loaded"/>
  <div class="form-elements" v-else>
    <div class="row">
      <div class="col-md-12">
        <vuestic-widget :headerText="'menu.slides.update' | translate">

          <div class="row row-reverse">
            <div class="col-6">
              <div class="row row-reverse">
                <div class="col">
                  <div class="form-group with-icon-right"
                       :class="{'has-error': errors.has('title')}">
                    <div class="input-group">
                      <input
                        id="title"
                        name="title"
                        v-model="title"
                        v-validate="'required'"
                        required/>
                      <i
                        class="fa fa-exclamation-triangle icon-right input-icon"
                        v-show="errors.has('title')"></i>
                      <label class="control-label" for="title">{{'slide.title'
                        | translate}}</label><i class="bar"></i>
                      <small v-show="errors.has('title')"
                             class="help text-danger">{{
                        errors.first('title')
                        }}
                      </small>
                    </div>
                  </div>
                </div>

                <div class="col">
                  <div class="form-group with-icon-right"
                       :class="{'has-error': errors.has('url')}">
                    <div class="input-group">
                      <input
                        id="url"
                        name="url"
                        v-model="url"/>
                      <i
                        class="fa fa-exclamation-triangle icon-right input-icon"
                        v-show="errors.has('url')"></i>
                      <label class="control-label" for="url">{{'slide.url'
                        | translate}}</label><i class="bar"></i>
                      <small v-show="errors.has('url')"
                             class="help text-danger">{{
                        errors.first('url')
                        }}
                      </small>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row row-reverse">
                <div class="col">
                  <div class="form-group with-icon-right"
                       :class="{'has-error': errors.has('order')}">
                    <div class="input-group">
                      <input
                        id="order"
                        name="order"
                        v-model="order"
                        v-validate="'required'"
                        type="number"
                        required/>
                      <i
                        class="fa fa-exclamation-triangle icon-right input-icon"
                        v-show="errors.has('order')"></i>
                      <label class="control-label" for="order">{{'slide.order'
                        | translate}}</label><i class="bar"></i>
                      <small v-show="errors.has('order')"
                             class="help text-danger">{{
                        errors.first('order')
                        }}
                      </small>
                    </div>
                  </div>
                </div>

                <div class="col">
                  <vuestic-switch v-model="site">
                    <span slot="falseTitle">
                      {{'slide.site_no' | translate}}
                    </span>
                    <span slot="trueTitle">
                      {{'slide.site_yes' | translate}}
                    </span>
                  </vuestic-switch>
                </div>
              </div>
            </div>

            <div class="col-6">
              <div class="row">
                <div class="col">
                  <Uploader
                    :maxFiles="1"
                    :images="getMobile"
                    :apiUrl="mobileApiUrl"
                    @onChange="reInitImage"
                    :placeholder="'slide.mobile' | translate"                
                  />
                </div>
                <div class="col">
                  <Uploader
                    :maxFiles="1"
                    :apiUrl="apiUrl"
                    :images="getImage"
                    @onChange="reInitImage"
                    :placeholder="'slide.image' | translate"                
                  />
                </div>
              </div>              
            </div>
          </div>

          <div class="row">
            <div class="col col text-center mt-4">
              <button class="btn btn-success"  @click="update">
                {{'buttons.update' | translate}}
              </button>
            </div>
          </div>
        </vuestic-widget>        
      </div>
    </div>
  </div>
</template>
