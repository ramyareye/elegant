<script>
  import _ from 'lodash'
  import api from 'src/packages/Api' 

  import Editor from 'view/components/editor'  
  import dataInput from 'view/components/data-input'
  import bodyWidget from 'view/components/body-widget'
  import Multiselect from 'view/components/multiselect'

  export default {
    name: 'create-post',
    data () {
      return {
        title: '',
        editor: {},
        excerpt: '',        
        visible: true,        
        
        category: {},
        categories: []
      }
    },
    components: {
      Editor,
      Reference,
      dataInput,
      bodyWidget,
      Multiselect    
    },
    methods: {
      handleEditor (editor) {
        this.editor = editor
      },
      
      findCategory (categories) {
        this.categories = categories
      },
      selectCategory (category) {
        if (category !== undefined) {
          this.category = category
        }        
      },

      add () {
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
              
              api.post('posts', data).then(response => {
                this.$store.dispatch('addToastMessage',
                  { text: this.$t('post.created'), type: 'success' }
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
  <body-widget :title="'menu.properties.update' | translate" v-else>

    <div class="row row-reverse">
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
                <label class="control-label" for="title">{{'page.title'
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
          <Editor @editor="handleEditor"/>
        </div>        
      </div>
    </div>

    <div class="row mt-5">
      <div class="col text-center">
        <button class="btn btn-success"  @click="add">
          {{'buttons.submit' | translate}}
        </button>
      </div>
    </div>

  </body-widget>
</template>
