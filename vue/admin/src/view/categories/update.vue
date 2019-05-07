<script>
  import _ from 'lodash'
  import api from 'src/packages/Api'  

  import Loading from 'partials/Loading'
  import Editor from 'view/components/editor'
  import Uploader from 'view/components/uploader'
  import Multiselect from 'view/components/multiselect'
  import MultiTagselect from 'view/components/multitagselect'
  
  export default {
    name: 'update-category',
    data () {
      return {
        category: {},
        id: '',
        name: '',
        slug: '',
        description: '',
        menu: false,

        link: '',
        keywords: '',
        content: '',

        editor: null,
        
        parent: {},
        categories: [],

        tag: [],
        tags: [],

        writer: {},
        writers: [],

        tabs: [],
        showTabs: true,
        
        loaded: false,
        apiUrl: 'categories/' + this.$route.params.id + "/upload/images",
        coverApiUrl: 'categories/' + this.$route.params.id + "/upload/cover",
        imageApiUrl: 'categories/' + this.$route.params.id + "/upload/image"
      }
    },
    components: {
      Editor,
      Loading,
      Uploader,
      Multiselect,
      MultiTagselect
    },
    async created () {
      try {
        const response = await api.get(`categories/${this.$route.params.id}`)
        const writers = await api.get('consultants')

        const res = response.data
        
        this.category = res
        this.id = res.id
        this.menu = res.menu ? true : false
        this.name = res.name
        this.slug = res.slug
        this.link = res.link
        this.keywords = res.keywords
        this.description = res.description        
        this.parent = res.parent_id ? res.parent.data : {}
        this.type = this.types.find(t => t.id === res.type)

        if (res.writer_id) {
          this.writer = res.writer.data          
        }

        this.writers = writers.data
        
        res.tags.map(t => { this.tag.push({id: t.name, name: t.name}) })

        const tabs = await api.get('categories/tabs/' + res.id)

        this.tabs = tabs.data

        this.loaded = true
      } catch(error) {  
        this.$store.dispatch('addToastMessage',
          { text: this.$t(`errors.${error.data.status_code}`) }
        )
        this.$router.push({ name: 'categories' })
      }
    },
    methods: {
      getImages () {
        const images = this.category.images.data || []

        return images
      },

      getCover () {
        const cover = this.category.cover
          ? [this.category.cover.data] 
          : []

        return cover
      },

      getImage () {
        const image = this.category.image
          ? [this.category.image.data] 
          : []

        return image
      },

      reInitImages (response) {
        this.category = response.data
      },

      findCategory (categories) {
        this.categories = categories
      },

      selectCategory (category) {
        if (category !== undefined) {
          this.parent = category
        }        
      },

      selectWriter (writer) {
        if (writer !== undefined) {
          this.writer = writer
        }        
      },

      findTag (result) {
        const tags = result.map(tag => { return { id: tag.name, name: tag.name } })

        this.tags = tags
      },

      selectTags (tag) {
        this.tag = tag
      },

      handleEditor (editor) {
        this.editor = editor

        this.editor.setContents(this.category.content || '')
      },

      updateTagImages (tab) {
        const tabs = this.tabs
        this.tabs = []

        this.tabs = tabs.map(t => {
          if (tab.id === t.id) {
            return tab
          } else {
            return t
          }          
        })
      },

      update () {

        this.$validator.validateAll().then((result) => {
          const tags = this.tag.map(t => t.name)

          if (result) {
            const data = {
              name: this.name,
              slug: this.slug,
              menu: this.menu ? 1 : 0,
              parent_id: _.isEmpty(this.parent) ? 0 : this.parent.id,
              writer_id: _.isEmpty(this.writer) ? null : this.writer.identifier,
              link: this.link,
              keywords: this.keywords,
              description: this.description,
              content: this.editor.getContents(),
              tags
            }

            api.put(`categories/${this.id}`, data).then(response => {
              this.$store.dispatch('addToastMessage',
                { text: this.$t('category.updated'), type: 'success' }
              )
              this.$router.push({ name: 'category', params: { id: response.data.id } })
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
        <vuestic-widget :headerText="'menu.categories.update' | translate">
          
          <div class="row">
            <div class="col">
              <div class="row row-reverse">
                <div class="col">
                  <div class="form-group with-icon-right"
                       :class="{'has-error': errors.has('name')}">
                    <div class="input-group">
                      <input
                        id="name"
                        name="name"
                        v-model="name"
                        v-validate="'required'"
                        required/>
                      <i
                        class="fa fa-exclamation-triangle icon-right input-icon"
                        v-show="errors.has('name')"></i>
                      <label class="control-label" for="name">{{'category.name'
                        | translate}}</label><i class="bar"></i>
                      <small v-show="errors.has('name')"
                             class="help text-danger">{{
                        errors.first('name')
                        }}
                      </small>
                    </div>
                  </div>
                </div>

                <div class="col">
                  <div class="form-group with-icon-right"
                       :class="{'has-error': errors.has('slug')}">
                    <div class="input-group">
                      <input
                        id="slug"
                        name="slug"
                        v-model="slug"
                        v-validate="'required'"
                        required/>
                      <i
                        class="fa fa-exclamation-triangle icon-right input-icon"
                        v-show="errors.has('slug')"></i>
                      <label class="control-label" for="slug">{{'category.slug'
                        | translate}}</label><i class="bar"></i>
                      <small v-show="errors.has('slug')"
                             class="help text-danger">{{
                        errors.first('slug')
                        }}
                      </small>
                    </div>
                  </div>
                </div>

                <div class="col">
                  <multiselect
                    :select="parent"
                    :selects="categories"
                    :apiUrl="'categories/search'"
                    :rtl="true" 
                    @search="findCategory"
                    @select="selectCategory"
                  />
                </div>

                <div class="col">
                  <multiselect
                    :select="writer"
                    :selects="writers"
                    :rtl="true" 
                    @select="selectWriter"
                    :placeholder="'category.writer' | translate"
                  />
                </div>

                <div class="col">
                  <multiselect
                    :select="writer2"
                    :selects="writers"
                    :rtl="true" 
                    @select="selectWriter2"
                    :placeholder="'category.writer' | translate"
                  />
                </div>
              </div>

              <div class="row row-reverse">
                <div class="col">
                  <multi-tagselect
                    :value="[]"
                    :rtl="true"
                    :select="tag"
                    :selects="tags"
                    @search="findTag"
                    @select="selectTags"
                    :apiUrl="'tags/search'"
                    :placeholder="'tag.tag' | translate"
                  />
                </div>

                <div class="col">
                  <div class="form-group with-icon-right"
                       :class="{'has-error': errors.has('keywords')}">
                    <div class="input-group">
                      <input
                        id="keywords"
                        name="keywords"
                        v-model="keywords"
                      />
                      <i
                        class="fa fa-exclamation-triangle icon-right input-icon"
                        v-show="errors.has('keywords')"></i>
                      <label class="control-label" for="keywords">{{'category.keywords'
                        | translate}}</label><i class="bar"></i>
                      <small v-show="errors.has('keywords')"
                             class="help text-danger">{{
                        errors.first('keywords')
                        }}
                      </small>
                    </div>
                  </div>
                </div>

                <div class="col">
                  <vuestic-switch v-model="menu">
                    <span slot="falseTitle">
                      {{'category.menu_no' | translate}}
                    </span>
                    <span slot="trueTitle">
                      {{'category.menu_yes' | translate}}
                    </span>
                  </vuestic-switch>
                </div>

                <div class="col">
                  <multiselect
                    :select="type"
                    :selects="types"
                    :rtl="true" 
                    :allowEmpty="false"
                    @select="selectType"
                    :placeholder="'category.type' | translate"
                  />
                </div>
              </div>

              <div class="row mt-2">
                <textarea 
                  id="description"
                  class="col-md-12"
                  v-model="description"
                  :placeholder="'category.description' | translate"
                >
                </textarea>
              </div>

              <div class="row mt-2">
                <div class="col-3">
                  <Uploader
                    :maxFiles="1"
                    :placeholder="'category.cover' | translate"
                    :images="getCover"
                    :apiUrl="coverApiUrl"
                    @onChange="reInitImages"
                  />
                </div>
                <div class="col-3">
                  <Uploader
                    :maxFiles="1"
                    :placeholder="'category.image' | translate"
                    :images="getImage"
                    :apiUrl="imageApiUrl"
                    @onChange="reInitImages"
                  />
                </div>
                <div class="col-6">
                  <Uploader
                    :placeholder="'category.images' | translate"
                    :images="getImages"
                    :apiUrl="apiUrl"
                    @onChange="reInitImages"
                  />
                </div>
              </div>

              <div class="row mt-2">
                <Editor @editor="handleEditor"/>
              </div>

              <div class="row mt-5">
                <div class="col justify-content-center text-center">
                  <button class="btn btn-success"  @click="update">
                    {{'buttons.update' | translate}}
                  </button>
                </div>
              </div>

              <div class="row mt-5">
                <div class="col" v-html="category.old_content"></div>
              </div>
            </div>
          </div>          

        </vuestic-widget>        
      </div>
    </div>
  </div>
</template>

<style>
  .vuestic-switch .vuestic-switch-option {
    padding: 8px;
  }
</style>