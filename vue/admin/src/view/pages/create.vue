<script>
  import api from 'src/packages/Api'
  import Loading from 'partials/Loading'
  import Editor from 'view/components/editor'
  
  import types from './types'
  import sidebars from './sidebars'

  export default {
    name: 'create-page',
    data () {
      return {
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
        loaded: false
      }
    },

    components: {
      Editor,
      Loading
    },

    async mounted () {
      try {
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

        this.parent = this.parents[0]

        this.types = types

        this.type = types[0]

        this.sidebars = sidebars

        this.sidebar = sidebars[0]

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
      },
      
      add () {
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

            api.post('pages', data).then(response => {
              this.$store.dispatch('addToastMessage',
                { text: this.$t('page.created'), type: 'success' }
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
        <vuestic-widget :headerText="'menu.pages.create' | translate">

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
          </div>

          <div class="row mt-2">
            <Editor @editor="handleEditor"/>
          </div>

          <div class="row">
            <div class="col mt-5 text-center">
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
