<script>
import Modal from './modal'
import api from 'src/packages/Api'
import vue2Dropzone from 'vue2-dropzone'

import 'vue2-dropzone/dist/vue2Dropzone.min.css'

export default {
  name: 'uploader',

  data () {
    return {
      file: false,
      options: {},
      loading: false,
      deleting: false,
      hoverSlot: false
    }
  },

  props: {
    hasSlot: {
      type: Boolean,
      defalut: false
    },
    apiUrl: {
      type: String,
      required: true
    },
    deleteApiUrl: {
      type: String,
      default: ''
    },
    images: {
      type: Function,
      required: true
    },
    maxFiles: {
      type: Number,
      default: 100
    },
    allowDelete: {
      type: Boolean,
      default: true
    },
    onlyImg: {
      type: Boolean,
      default: false
    },
    placeholder: String,
    defaultImg: String
  },

  components: {
    Modal,
    vueDropzone: vue2Dropzone    
  },

  created () {
    const token = this.$store.getters.token

    this.options = {      
      timeout: 5000,
      maxFilesize: 4,
      uploadMultiple: false,
      maxFiles: this.maxFiles,
      acceptedFiles: ".jpeg,.jpg,.png,.gif",

      url: `api/${this.apiUrl}`,
      headers: { Authorization: `Bearer ${token}` },
      dictFileTooBig: this.$i18n.translate('file.big'),
      dictDefaultMessage: this.placeholder || this.$i18n.translate('file.upload'),

      renameFile: (file) => this.renameFile(file),
      success: (file, response) => this.onSuccess(file, response),
      error: (error, message, xhr) => this.onError(error, message, xhr)
      // maxfilesexceeded: (file) => console.log(['maxfilesexceeded', file])      
    }
  },

  mounted () {
    this.init()
  },

  beforeDestroy () {
    this.$refs.dropzoneRef.destroy()
  },

  computed: {      
    bg () {
      const img = this.defaultImg

      return `background-image: url('${img}')`
    }
  },

  methods: {
    init () {
      const images = this.images()
      
      images.map(
        image => this.$refs.dropzoneRef.manuallyAddFile(image, image.url.small)
      )

      this.addOnClick()
    },

    reInit (response) {
      this.$emit('onChange', response)

      this.$refs.dropzoneRef.removeAllFiles()

      this.init()
    },

    addOnClick () {
      let that = this

      this.$refs.dropzoneRef.dropzone.files.map(file => {
        file.previewElement.addEventListener("click", function() {
          that.file = file
        })
      })
    },

    renameFile (file) {
      const dt = new Date()
      const time = dt.getTime()

      return time + '-' + file.name
    },

    onSuccess (file,response) {
      this.reInit(response)
    },

    onError (file, message, xhr) {
      this.$refs.dropzoneRef.removeFile(file)
      this.$store.dispatch('addToastMessage', { text: message })
    },

    deleteFile () {
      if (!this.allowDelete || this.deleting) return 

      let that = this
      const file = this.file

      this.$swal({
        type: 'warning',
        showCancelButton: true,
        cancelButtonColor: '#d33',
        confirmButtonColor: '#3085d6',
        title: that.$i18n.translate('alert.sure'),
        text: that.$i18n.translate('alert.sure_text'),
        cancelButtonText: that.$i18n.translate('alert.cancel'),
        confirmButtonText: that.$i18n.translate('alert.confirm') 
      }).then((result) => {
        if (result.value) {
          that.deleting = true

          api.post(that.deleteApiUrl ? that.deleteApiUrl : `${that.apiUrl}/${file.id}`).then(response => {
            that.reInit(response)
            
            that.$swal({
              type: 'success',
              title: that.$i18n.translate('uploader.deleted'),
              text: that.$i18n.translate('uploader.deleted_text'),
              confirmButtonText: that.$i18n.translate('alert.confirm')
            })
          }).finally(() => {
            that.file = false
            that.deleting = false
          })
        }
      })
    }
  }
}

</script>

<template>
  <div>
    <vue-dropzone 
      ref="dropzoneRef" 
      id="dropzone" 
      :options="options"
      :useCustomSlot="!!defaultImg"
    >
      <div 
        :style="bg"
        class="dropzone-bg"
        @mouseover="hoverSlot = true" @mouseleave="hoverSlot = false"
      >
        <transition name="fade">
          <i class="glyphicon glyphicon-pencil" v-show="hoverSlot"></i>
        </transition>
      </div>
    </vue-dropzone>

    <modal v-if="file" @onClose="file = false">
      <template slot="header" v-if="!onlyImg">
        <div class="col text-center">
          {{ file.name }}
        </div>
      </template>

      <template slot="body">
        <div class="modal-body text-center">
          <img :src="file.url.medium" />
          
          <div class="row" v-for="(link, index) in file.url" v-if="!onlyImg">
            <div class="col-md-3">
              {{ `uploader.${index}` | translate}} :
            </div>
            <div class="col-md-9 text-center">
              <!-- <input type="text" :value="file.url.thumb"disabled
                v-clipboard:copy="file.url.main"
              /> -->
              <a target="_blank"
                :href="link"
                v-html="$t('uploader.open')"
                class="btn btn-info btn-micro"                 
              />
              <button 
                style="margin-right: 10px;"
                class="btn btn-primary btn-micro"                
                v-clipboard:copy="`file.url.${index}`"
                v-html="$t('uploader.copy')"
              ></button>
            </div>
            <!-- <div class="col-md-3"></div> -->
          </div>

        </div>        
      </template>

      <template slot="footer">
        <button 
          @click="file = false"
          v-html="$t('uploader.close')"
          class="btn btn-info btn-micro"
        ></button>
        <button 
          v-if="allowDelete"
          @click="deleteFile"
          v-html="$t('uploader.delete')"
          class="btn btn-danger btn-micro"          
        ></button>
      </template>
    </modal>

  </div>
</template>

<style>
.dz-image-preview * {
  cursor: pointer !important;
}

.modal-mask {
  position: fixed;
  z-index: 100000;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, .5);
  display: table;
  transition: opacity .3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

.modal-container {
  width: 500px;
  margin: 0px auto;
  padding: 20px 30px;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
  transition: all .3s ease;
  font-family: Helvetica, Arial, sans-serif;
  max-height: 90%;
  overflow-y: scroll;
}

.modal-header h3 {
  margin-top: 0;
  color: #42b983;
}

.modal-body {
  margin: 20px 0;
}

.modal-default-button {
  float: right;
}

/*
 * The following styles are auto-applied to elements with
 * transition="modal" when their visibility is toggled
 * by Vue.js.
 *
 * You can easily play with the modal transition by editing
 * these styles.
 */

.modal-enter {
  opacity: 0;
}

.modal-leave-active {
  opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}

.modal-header h3 {
  margin-top: 0;
  color: #42b983;
}

.modal-body {
  margin: 20px 0;
  padding: 0;
}

.modal-body img {
  max-width: 100%;
}

.modal-default-button {
  float: right;
}

.modal-body .row {
    margin: 15px auto;
}

.modal-body .row div:first-child {
  color: #4ae387;
}

.modal-footer .btn {
  margin: auto;
}

.modal-body .row input {
  border-radius: 5px;
  width: 100%;
  padding: 5px 5px 0px;
  border-color: #7cdb8c;
  cursor: pointer;
}

.swal2-container.swal2-shown {
  z-index: 100000;
}

.btn {
  padding-bottom: 5px;
  margin-top: 5px;
}

.dropzone {
  text-align: center;
}

.dropzone .dz-message {
  margin: 0;
}

.dropzone-bg {
  margin: auto;
}

.vue-dropzone,
.vue-dropzone:hover {
  background: transparent;
  border: 0;
}

.dropzone .dz-preview.dz-image-preview {
  margin: auto;
}
</style>