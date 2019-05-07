<template>
	<loading v-if="!loaded"/>
  <div class="form-elements" v-else>
    <div class="row">
      <div class="col-md-12">
        <vuestic-widget :headerText="'menu.admins.update' | translate">
          <div class="row">
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
                  <label class="control-label" for="name">{{'user.name'
                    | translate}}</label><i class="bar"></i>
                  <small v-show="errors.has('name')"
                         class="help text-danger">{{
                    errors.first('name')
                    }}
                  </small>
                </div>
              </div>

              <div class="form-group with-icon-right"
                   :class="{'has-error': errors.has('mobile')}">
                <div class="input-group">
                  <input
                    id="mobile"
                    name="mobile"
                    v-model="mobile"
                    v-validate="'integer'"/>
                  <i
                    class="fa fa-exclamation-triangle icon-right input-icon"
                    v-show="errors.has('mobile')"></i>
                  <label class="control-label" for="mobile">{{'user.mobile'
                    | translate}}</label><i class="bar"></i>
                  <small v-show="errors.has('mobile')"
                         class="help text-danger">{{
                    errors.first('mobile')
                    }}
                  </small>
                </div>
              </div>

              <vuestic-switch v-model="active">
                <span
                  slot="trueTitle">{{'user.active_y' | translate}}</span>
                <span slot="falseTitle">{{'user.active_n' | translate}}</span>
              </vuestic-switch>
            </div>

            <div class="col">
              <div class="form-group with-icon-right"
                   :class="{'has-error': errors.has('family')}">
                <div class="input-group">
                  <input
                    id="family"
                    name="family"
                    v-model="family"
                    v-validate="'required'"
                    required/>
                  <i
                    class="fa fa-exclamation-triangle icon-right input-icon"
                    v-show="errors.has('family')"></i>
                  <label class="control-label" for="family">{{'user.family'
                    | translate}}</label><i class="bar"></i>
                  <small v-show="errors.has('family')"
                         class="help text-danger">{{
                    errors.first('family')
                    }}
                  </small>
                </div>
              </div>
            </div>

            <div class="col">
              <div class="form-group with-icon-right"
                   :class="{'has-error': errors.has('email')}">
                <div class="input-group">
                  <input
                    id="email"
                    name="email"
                    v-model="email"
                    v-validate="'required|email'"
                    required/>
                  <i
                    class="fa fa-exclamation-triangle icon-right input-icon"
                    v-show="errors.has('email')"></i>
                  <label class="control-label" for="email">{{'user.email'
                    | translate}}</label><i class="bar"></i>
                  <small v-show="errors.has('email')"
                         class="help text-danger">{{
                    errors.first('email')
                    }}
                  </small>
                </div>
              </div>
            </div>

            <div class="col">
              <picture-input 
                ref="avatarInput"
                width="600" 
                height="600" 
                margin="16" 
                accept="image/jpeg,image/png"
                size="10" 
                :prefill="avatar"
                button-class="btn"
                :hideChangeButton=true
                :custom-strings="{
                  upload: '<h1>Avatar</h1>',
                  drag: $t('user.upload_avatar')
                }"
                @change="onAvatarChange">
              </picture-input>
            </div>
          </div>


          <div class="row">
            <div class="col">
              <div class="form-group with-icon-right"
                   :class="{'has-error': errors.has('textarea')}">
                <div class="input-group">
                  <textarea type="text" id="about" v-model="about" required rows="6"></textarea>
                  <label class="control-label" for="about">{{'user.about'
                    | translate}}</label><i class="bar"></i>
                </div>
              </div>           
            </div>
            <div class="col">
            </div>
          </div>
          <div class="row mt-5">
            <div class="col text-center">
              <button class="btn btn-success"  @click="add">
                {{'buttons.update' | translate}}
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
  import Loading from 'partials/Loading'
  import PictureInput from 'vue-picture-input'

  export default {
    name: 'updateAdmin',
    data () {
      return {
        user: {},
        name: '',
        family: '',
        email: '',
        mobile: '',
        active: true,
        about: '',
        avatar: '',
        avatar_id: '',
        loaded: false
      }
    },
    components: {
      Loading,
      PictureInput
    },
    created () {
      api.get(`admins/${this.$route.params.id}`).then(response => {
        const res = response.data

        this.user = res
        this.id = res.id
        this.name = res.name
        this.family = res.family
        this.email = res.email
        this.mobile = res.mobile
        this.active = res.active === 1
        this.about = res.about

        if (res.avatar_id) {
          this.avatar_id = res.avatar.data.id
          this.avatar = res.avatar.data.path
        }

        this.loaded = true
      }).catch(error => {
        this.$store.dispatch('addToastMessage',
          { text: Vue.i18n.translate(`errors.${error.data.status_code}`) }
        )
        this.$router.push({ name: 'Admins' })
      })
    },
    methods: {
      onAvatarChange (image) {
        if (image) {
          const img = this.$refs.avatarInput.file
          const base64 = image.replace(/^data:image\/\w+;base64,/, '')
          const data = {
            'name': img.name,
            'type': img.type,
            'size': img.size,
            'content': base64,
            'model': 'users'
          }

          api.post('assets', data).then(res => {
            this.avatar_id = res.data.id
          }).catch(error => {
            this.$store.dispatch('addToastMessage', { text: error.data.message })
          })
        }
      },
      add () {
        this.$validator.validateAll().then((result) => {
          if (result) {
            const data = {
              name: this.name,
              email: this.email,
              about: this.about,
              mobile: this.mobile,
              active: this.active,
              family: this.family,
              avatar_id: this.avatar_id
            }

            api.put(`admins/${this.id}`, data).then(response => {
              this.$store.dispatch('addToastMessage',
                { text: Vue.i18n.translate('admin.updated'), type: 'success' }
              )
              this.$router.push({ name: 'Admin', params: { id: response.data.id } })
            }).catch(error => {
              this.$store.dispatch('addToastMessage',
                { text: Vue.i18n.translate('errors.any'), error }
              )
              for (let e in error.data.errors) {
                error.data.errors[e].map(text => {
                  this.$store.dispatch('addToastMessage',
                    { text }
                  )
                })
              }
            })
          }
        })
      }
    }
  }
</script>

<style>
.vuestic-switch .vuestic-switch-option {
  padding: 0.313rem 1.375rem !important;
}
</style>