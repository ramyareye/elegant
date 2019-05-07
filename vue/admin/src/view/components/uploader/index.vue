<template>
  <div>
  	<div class="mt-5">
  	  <vue-dropzone 
  	    ref="dropzoneRef" 
  	    id="dropzone" 
  	    :options="options"
  	  >
    	</vue-dropzone>
    </div>

    <modal v-if="file" @close="file = false" :file="file">
      <h3 slot="header">{file.name}</h3>

      <img slot="body" :src="file.url.medium"/>
    </modal>
  </div>
</template>

<script>
import vue2Dropzone from 'vue2-dropzone'
import Modal from 'view/components/modal'

import 'vue2-dropzone/dist/vue2Dropzone.min.css'

export default {
	name: 'uploader',

  data () {
  	return {
      file: false,
  		options: {},
	    loading: false      
	  }
  },

  props: {
    apiUrl: {
      type: String,
    	required: true
    },
    images: {
      type: Array,
    	required: true
    }
  },

  components: {
    Modal,
    vueDropzone: vue2Dropzone    
  },

  created () {
    const token = this.$store.getters.token

    this.options = {
    	timeout: 5000,
			maxFilesize: 2,
      uploadMultiple: false,
      acceptedFiles: ".jpeg,.jpg,.png,.gif",

      url: this.apiUrl,
      headers: { Authorization: `Bearer ${token}` },
      dictFileTooBig: this.$i18n.translate('file.big'),
			dictDefaultMessage: this.$i18n.translate('file.upload'),

			// init: () => this.init(),
      renameFile: (file) => this.renameFile(file),
      success: (file, response) => this.onSuccess(file, response),
			error: (error, message, xhr) => this.onError(error, message, xhr),
			fileAddedManually: () => console.log(1231)
    }
  },

  mounted () {
    let that = this

    this.images.map(image => {
    // 	console.log(image)
    // 	console.log(image.previewElement.addEventListener("click", function() {
		  //   myDropzone.removeFile(file)
		  // }))
    	this.$refs.dropzoneRef.manuallyAddFile(image, image.url.small)
		})
		this.$refs.dropzoneRef.dropzone.files.map(file => {
        file.previewElement.addEventListener("click", function() {
          console.log(that)
          that.file = file
          console.log(that)
        })
    })
  },

  // beforeDestroy () {
  //   this.destroyUploader()
  // },

  methods: {
  	// init () {
  	// 	console.log(this)
  	// 	console.log(this.$refs.dropzoneRef.getAddedFiles())
  		// this.$refs.dropzoneRef.previewElement.addEventListener("click", function() {
    //     alert(file.name)
    //   })
  	// },
  	renameFile (file) {
      const dt = new Date()
      const time = dt.getTime()

     	return time + '-' + file.name
  	},
  	onSuccess (file,response) {
  		this.$emit('onUpload', response)
  	},
  	onError (file, message, xhr) {
  		this.$store.dispatch('addToastMessage',
        { text: this.$i18n.translate(`errors.${message.status_code}`) }
      )
  	},

    // destroyUploader () {
    //   this.$refs.dropzoneRef.destroy()
    // }
  }
}

</script>

<style>
.dz-image-preview * {
  cursor: pointer !important;
}

.modal-mask {
  position: fixed;
  z-index: 9998;
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
  width: 300px;
  margin: 0px auto;
  padding: 20px 30px;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
  transition: all .3s ease;
  font-family: Helvetica, Arial, sans-serif;
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
</style>