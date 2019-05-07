<script>  
  import _ from 'lodash'
  import api from 'src/packages/Api'
  import Loading from 'partials/Loading'
  import Editor from 'view/components/editor'
  import Uploader from 'view/components/uploader/'
  import Multiselect from 'view/components/multiselect'

  export default {
    name: 'update-post',
    data () {
      return {
        post: {},
        title: '',
        editor: {},
        excerpt: '',
        visible: true,

        category: {},
        categories: [],
        loaded: false,

        apiUrl: 'api/posts/' + this.$route.params.id + "/upload/images"
      }
    },
    components: {
      Editor,
      Loading,
      Uploader,
      Multiselect
    },
    created () {
      api.get(`posts/${this.$route.params.id}`).then(response => {
        const res = response.data

        this.post = res
        this.id = res.id
        this.title = res.title        
        this.excerpt = res.excerpt
        this.visible = res.visible ? true : false

        this.category = res.categories.data.length > 0 ? res.categories.data[0] : {}

        this.loaded = true
      }).catch(error => {
        this.$store.dispatch('addToastMessage',
          { text: this.$t(`errors.${error.data.status_code}`) }
        )
        this.$router.push({ name: 'posts' })
      })
    },
    methods: {
      handleEditor (editor) {
        this.editor = editor

        this.editor.setContents(this.post.body)
      },
      getImages () {
        const images = this.post.images.data || []

        return images
      },
      
      uploadImage (response) {
        this.post = response.data
      },

      findCategory (categories) {
        this.categories = categories
      },
      selectCategory (category) {
        if (category !== undefined) {
          this.category = category
        }        
      },
      
      update () {
        if (_.isEmpty(this.category)) {
          this.$store.dispatch('addToastMessage', { text: this.$t('errors.category') })
        } else {
          this.$validator.validateAll().then((result) => {
            if (result) {
              const data = {
                title: this.title,
                excerpt: this.excerpt,
                visible: this.visible,
                body: this.editor.getContents(),
                category: this.category.id
              }
              
              api.put(`posts/${this.id}`, data).then(response => {
                this.$store.dispatch('addToastMessage',
                  { text: this.$t('post.updated'), type: 'success' }
                )

                this.$router.push({ name: 'post', params: { id: response.data.id } })
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
  }
</script>

<template>
  <loading v-if="!loaded"/>
  <div class="form-elements" v-else>
    <div class="row">
      <div class="col-md-12">
        <vuestic-widget :headerText="'menu.posts.update' | translate">
          <div class="row">
            <div class="col">
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
                      <label class="control-label" for="title">{{'post.title'
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
                  <multiselect
                    :select="category"
                    :selects="categories"
                    :apiUrl="'categories/search'"
                    :rtl="true" 
                    @search="findCategory"
                    @select="selectCategory"
                  />
                </div>

                <div class="col">
                  <vuestic-switch v-model="visible">
                    <span
                      slot="trueTitle">{{'post.visible_yes' | translate}}</span>
                    <span slot="falseTitle">{{'post.visible_no' | translate}}</span>
                  </vuestic-switch>
                </div> 
              </div>

              <div class="row">
                <div class="col">
                  <textarea v-model="excerpt" style="width: 100%; height: 150px;"></textarea>
                </div>
              </div>

              <div class="row">
                <div class="col">
                  <Uploader
                    :apiUrl="apiUrl" 
                    :images="getImages"
                    @onUpload="uploadImage"
                  />
                </div>
              </div>
            </div>

            <div class="row">
              <Editor @editor="handleEditor"/>
            </div>
            
          </div>

          <div class="row mt-5">
            <div class="col col text-center">
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
