<script>  
  import api from 'src/packages/Api'
  import Loading from 'partials/Loading'
  import Editor from 'view/components/editor'
  import Uploader from 'view/components/uploader'

  import types from './types'
  import sidebars from './sidebars'
  
  export default {
    name: 'update-page',
    data () {
      return {
        page: {},
        title: '',
        slug: '',
        excerpt: '',
        description: '',
        visible: true,
        parent_id: 0,
        children: false,
        sidebar: {},
        sidebars: [],

        type: '',
        types: [],

        parent: {},
        parents: [],

        editor: null,
        loaded: false,
        apiUrl: 'pages/' + this.$route.params.id + "/upload/images",
        coverApiUrl: 'pages/' + this.$route.params.id + "/upload/cover",
        imageApiUrl: 'pages/' + this.$route.params.id + "/upload/image"
      }
    },
    components: {
      Editor,
      Loading,
      Uploader
    },
    
    async mounted () {
      try {
        const pageReq = await api.get(`pages/${this.$route.params.id}`)
        const parentsReq = await api.get('pages/parents')

        const defaultParent = [
          {
            id: 0,
            parent_id: null,
            title: this.$t('custom.no_parent')
          }
        ]

        const parents = parentsReq.data.map(parent => {
          return {
            id: parent.id,            
            title: parent.title,
            parent_id: parent.parent_id
          }
        })

        this.parents = [...defaultParent, ...parents]

        const page = pageReq.data

        this.page = page
        this.id = page.id
        this.title = page.title
        this.slug = page.slug
        this.excerpt = page.excerpt
        this.visible = page.visible ? true : false
        this.parent_id = page.parent_id
        this.children = page.children ? true : false

        if (page.parent_id) {
          this.parent = this.parents.find(p => p.id === page.parent_id)
        } else {
          this.parent = this.parents[0]
        }
        
        this.types = types

        this.type = types.find(p => p.key === page.type)

        this.sidebars = sidebars

        this.sidebar = sidebars.find(s => s.name === page.sidebar)

        this.loaded = true
      } catch(error) {
        this.$store.dispatch('addToastMessage',
          { text: this.$t(`errors.${error.data.status_code}`) }
        )
        this.$router.push({ name: 'pages' })
      }
    },
    methods: {
      handleEditor (editor) {
        this.editor = editor

        this.editor.setContents(this.page.body)
      },

      getImages () {
        const images = this.page.images.data || []

        return images
      },

      getCover () {
        const cover = this.page.cover
          ? [this.page.cover.data] 
          : []

        return cover
      },

      getImage () {
        const image = this.page.image
          ? [this.page.image.data] 
          : []

        return image
      },

      reInitImages (response) {
        this.page = response.data
      },

      update () {
        this.$validator.validateAll().then((result) => {
          if (result) {
            const data = {
              slug: this.slug,
              title: this.title,              
              excerpt: this.excerpt,
              visible: this.visible ? 1 : 0,
              parent_id: this.parent && this.parent.id !== 0 
                ? this.parent.id 
                : null,
              type: this.type.key,
              children: this.children,
              sidebar: this.sidebar.name,
              body: this.editor.getContents()
            }

            api.put(`pages/${this.id}`, data).then(response => {
              this.$store.dispatch('addToastMessage',
                { text: this.$t('page.updated'), type: 'success' }
              )
              this.$router.push({ name: 'page', params: { id: response.data.id } })
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
        <vuestic-widget :headerText="'menu.pages.update' | translate">

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
                      <label class="control-label" for="slug">{{'page.slug'
                        | translate}}</label><i class="bar"></i>
                      <small v-show="errors.has('slug')"
                             class="help text-danger">{{
                        errors.first('slug')
                        }}
                      </small>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row row-reverse">
                <div class="col">
                  <vuestic-simple-select                    
                    v-model="parent"
                    :clearable="false"
                    :optionKey="'title'"
                    :options="this.parents"
                    :label="'page.parent' | translate"
                  >
                  </vuestic-simple-select>
                </div>
                <div class="col">
                  <vuestic-switch v-model="children">
                    <span slot="falseTitle">
                      {{'page.children_no' | translate}}
                    </span>
                    <span slot="trueTitle">
                      {{'page.children_yes' | translate}}
                    </span>
                  </vuestic-switch>
                </div>
              </div>

              <div class="row row-reverse">
                <div class="col">
                  <vuestic-simple-select
                    v-model="type"
                    :clearable="false"
                    :optionKey="'name'"
                    :options="this.types"
                    :label="'page.type' | translate"
                  >
                  </vuestic-simple-select>
                </div>

                <div class="col">
                  <vuestic-simple-select
                    v-model="sidebar"
                    :clearable="false"
                    :optionKey="'title'"
                    :options="this.sidebars"
                    :label="'sidebar.label' | translate"
                  >
                  </vuestic-simple-select>
                </div>

                <div class="col">
                  <vuestic-switch v-model="visible">
                    <span
                      slot="trueTitle">{{'page.visible_yes' | translate}}</span>
                    <span slot="falseTitle">{{'page.visible_no' | translate}}</span>
                  </vuestic-switch>
                </div>
              </div>

              <div class="row row-reverse">
                <div class="col">
                  <textarea 
                    id="excerpt"
                    class="col-md-12"
                    v-model="excerpt"
                    :placeholder="'page.excerpt' | translate"
                  >
                  </textarea>
                </div>
              </div>
            </div>

            <div class="col-4">
              <div class="row">
                <div class="col">
                  <Uploader
                    :maxFiles="1"
                    :placeholder="'page.cover' | translate"
                    :images="getCover"
                    :apiUrl="coverApiUrl"
                    @onChange="reInitImages"
                  />
                </div>
              </div>
              <div class="row mt-3">
                <div class="col">
                  <Uploader
                    :maxFiles="1"
                    :placeholder="'page.image' | translate"
                    :images="getImage"
                    :apiUrl="imageApiUrl"
                    @onChange="reInitImages"
                  />
                </div>
              </div>              
            </div>
          </div>

          <div class="row">
            <div class="col mt-3 mb-5">
              <Uploader
                :apiUrl="apiUrl" 
                :images="getImages"
                @onChange="reInitImages"
              />
            </div>
          </div>

          <div class="row mt-2">
            <Editor @editor="handleEditor"/>
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
