<script>
  import api from 'src/packages/Api'
  
  export default {
    name: 'create-slide',
    data () {
      return {
        title: '',
        order: '',
        url: '',
        site: true,

        loaded: false
      }
    },

    methods: {
      create () {
        this.$validator.validateAll().then((result) => {
          if (result) {
            const data = {
              title: this.title,              
              order: this.order,
              url: this.url,
              site: this.site ? 1 : 0
            }

            api.post('slides', data).then(response => {
              this.$store.dispatch('addToastMessage',
                { text: this.$t('slide.created'), type: 'success' }
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
  <div class="form-elements">
    <div class="row">
      <div class="col-md-12">
        <vuestic-widget :headerText="'menu.slides.create' | translate">

          <div class="row row-reverse">
            <div class="col-8">
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

          </div>

          <div class="row">
            <div class="col col text-center mt-4">
              <button class="btn btn-success"  @click="create">
                {{'buttons.submit' | translate}}
              </button>
            </div>
          </div>
        </vuestic-widget>        
      </div>
    </div>
  </div>
</template>
