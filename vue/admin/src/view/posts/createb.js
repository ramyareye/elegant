<template>
  <div class="form-elements">
    <div class="row">
      <div class="col-md-12">
        <vuestic-widget :headerText="'menu.posts.create' | translate">
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
                  <vue-tags-input
                    v-model="category"
                    :tags="categories"
                    :autocomplete-items="categoriesItems"
                    :add-only-from-autocomplete="true"
                    @tags-changed="updateCategories"
                    :placeholder="'post.categories' | translate"
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
            </div>
          </div>

          <div class="row">
            <!-- <Editor @editor="handleEditor"/> -->
          </div>

          <div class="row">
            <!-- <ckeditor :editor="editorr"></ckeditor> -->
            <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
          </div>

          <!-- <div class="row">
            <div class="col">
              <textarea v-model="excerpt" style="width: 100%; height: 150px;"></textarea>
            </div>
          </div>

          <div class="row">
            <div class="col">
              <Vueditor ref="editor" style="height: 500px;"/>
            </div>
          </div> -->

          <div class="row mt-5">
            <div class="col text-center">
              <button class="btn btn-success"  @click="add">
                {{'buttons.submit' | translate}}
              </button>
            </div>
          </div>          
        </vuestic-widget>        
      </div>
    </div>
  </div>
</template>

<script>
  import Vue from 'vue'
  import api from 'src/packages/Api'
  import Editor from 'view/components/editor'
  import VueTagsInput from '@johmun/vue-tags-input'  

  import CKEditor from '@ckeditor/ckeditor5-vue';
  import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
  import ImagePlugin from '@ckeditor/ckeditor5-image/src/image';
  import EasyImagePlugin from '@ckeditor/ckeditor5-easy-image/src/easyimage';

  export default {
    name: 'create-post',
    data () {
      return {
        body: {},
        title: '',
        editor: {},
        excerpt: '',        
        visible: true,        
        
        category: '',
        categories: [],
        categoriesItems: [],

        editor: ClassicEditor,
        editorData: '<p>Content of the editor.</p>',
        editorConfig: {
          plugins: [
            ImagePlugin,
            EasyImagePlugin
          ]
        }

        // editorr: ClassicEditor
      }
    },
    components: {
      Editor,
      ckeditor: CKEditor.component,
      VueTagsInput      
    },
    methods: {
      handleEditor (editor) {
        this.editor = editor
      },
      updateCategories (newCategories) {
        this.categoriesItems = []
        this.categories = newCategories
      },
      initCategories () {
        if (this.category.length === 0) return

        const data = {
          category: `%${this.category}%`
        }

        clearTimeout(this.debounce)
        this.debounce = setTimeout(() => {
          api.post('categories/search', data).then(res => {
            this.categoriesItems = res.data.map(t => {
              return {
                id: t.id,
                text: t.title
              }
            })
          }).catch(error => {
            this.$store.dispatch('addToastMessage', { text: error.data.message })
          })
        }, 600)
      },
      add () {
        if (!this.categories[0]) {
          this.$store.dispatch('addToastMessage', { text: Vue.i18n.translate('errors.category') })
        } else {
          this.$validator.validateAll().then((result) => {
            if (result) {
              const data = {
                title: this.title,
                excerpt: this.excerpt,
                visible: this.visible,
                body: this.editor.getContents(),
                categories: this.categories.map(cat => cat.id)
              }
              
              api.post('posts', data).then(response => {
                this.$store.dispatch('addToastMessage',
                  { text: Vue.i18n.translate('post.created'), type: 'success' }
                )
                this.$router.push({ name: 'post', params: { id: response.data.id } })
              }).catch(error => {
                this.$store.dispatch('addToastMessage',
                  { text: Vue.i18n.translate('errors.any'), error }
                )
              })
            }
          })
        }
      }
    },
    watch: {
      'category': 'initCategories'
    }
  }
</script>

<style lang="scss">
  .fade-enter-active, .fade-leave-active {
    transition: opacity .5s;
  }

  .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0;
  }
</style>
