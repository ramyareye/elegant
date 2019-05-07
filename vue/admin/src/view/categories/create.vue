<script>
  import api from 'src/packages/Api'
  import Editor from 'view/components/editor'
  
  export default {
    name: 'create-category',
    data () {
      return {
        name: '',
        slug: '',
        description: '',
        parent: {},
        menu: false,

        editor: null,
        categories: []
      }
    },
    components: {
      Editor
    },
    created () {
      api.get('categories').then(response => {
        const res = response.data
        const def = {
          id: 0,
          name: this.$t('custom.no_parent')
        }

        this.parent = def
        this.categories.push(def)

        this.handleCategories(res)
      }).catch(error => {
        this.$store.dispatch('addToastMessage',
          { text: this.$t(`errors.${error.status}`) }
        )
        this.$router.push({ name: 'categories' })
      })
    },
    methods: {
      handleCategories (categories, $spacer = '') {
        for (let item in categories) {
          item = categories[item]

          const category = { 
            id: item.id, 
            name: $spacer + ' ' + item.name
          }

          this.categories.push(category)

          this.handleCategories(item.children, $spacer + '-')

          if (category.id === this.$route.params.parent) {
            this.parent = category
          }
        }
      },
      handleEditor (editor) {
        this.editor = editor
      },
      add () {
        if (!this.parent.id && this.parent.id !== 0) {
          this.$store.dispatch(
            'addToastMessage', 
            { text: this.$t('errors.category') }
          )
        } else {
          this.$validator.validateAll().then((result) => {
            if (result) {
              const data = {                
                name: this.name,
                slug: this.slug,
                menu: this.menu ? 1 : 0,
                parent_id: this.parent.id,
                description: this.editor.getContents()                
              }

              api.post('categories', data).then(response => {
                this.$store.dispatch('addToastMessage',
                  { text: this.$t('category.created'), type: 'success' }
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
  }
</script>

<template>
  <div class="form-elements">
    <div class="row">
      <div class="col-md-12">
        <vuestic-widget :headerText="'menu.categories.create' | translate">
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
                  <vuestic-simple-select
                    v-model="parent"
                    option-key="name"
                    :clearable="false"
                    v-validate="'required'"
                    v-bind:options="this.categories"
                    :label="'custom.parent' | translate"
                  >
                  </vuestic-simple-select>
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
              </div>

              <div class="row mt-2">
                <Editor @editor="handleEditor"/>
              </div>

            </div>
          </div>

          <div class="row mt-5">
            <div class="col justify-content-center text-center">
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
