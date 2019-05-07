<template>
	<textarea :id="editor_id" style="display:none;"></textarea>
</template>

<script>
  import Vue from 'vue'
  import suneditor from 'suneditor'
	import plugins from 'suneditor/src/plugins'

  export default {
    name: 'editor',
    
    data () {
      return {
        editor: {}
      }
    },

    props: {
	    editor_id: {
        type: String,
        default: 'editor'
      },
      mode: {
        type: String,
        default: 'inline'
      },
	    buttons: {
	      type: Array,
	      default: () => { return [] }
	    }
	  },

    mounted () {
      this.editor = this.initEditor()

	    this.$emit('editor', this.editor)
    },

    beforeDestroy () {
	    this.destroyEditor()
	  },

    methods: {
      initEditor () {
      	const lol = this
		        
      	const editor = suneditor.create(this.editor_id, {
      		mode: this.mode,
			    plugins: plugins,
			    minHeight: 200,
			    stickyToolbar: false,
			    // buttonList: [
		     //    [
			    //     'undo', 'redo',
			    //     'font', 'fontSize', 'formatBlock',
			    //     'bold', 'underline', 'italic', 'strike', 'subscript', 'superscript',
			    //     'removeFormat',
			    //     'fontColor', 'hiliteColor',
			    //     'indent', 'outdent',
			    //     'align', 'horizontalRule', 'list', 'table',
			    //     'link', 'image', 'video',
			    //     'fullScreen', 'showBlocks', 'codeView',
			    //     'preview', 'print'
		     //    ]
			    // ]
	      //   plugins: [
		     //    align,
		     //    font,
		     //    fontSize,
		     //    fontColor,
		     //    hiliteColor,
		     //    horizontalRule,
		     //    list,
		     //    table,
		     //    formatBlock,
		     //    link,
		     //    image,
		     //    video
			    // ],
			    buttonList: [
			    	['undo', 'redo'],
		        ['font', 'fontSize', 'formatBlock'],
		        ['fontColor', 'hiliteColor'],
		        ['align', 'horizontalRule', 'list', 'table'],
		        ['link', 'image', 'showBlocks', 'codeView'],
		        lol.buttons
			    ],
				})

				return editor
	    },

	    destroyEditor () {
	      this.editor.destroy()
	    }
    }
  }
</script>

<style lang="scss">
  @import '~suneditor/dist/css/suneditor.min.css';
	// or
	// import 'suneditor/src/assets/css/suneditor.css'
	// import 'suneditor/src/assets/css/suneditor-contents.css'

	.sun-editor .modal-dialog .editor_image .form-group:first-child {
		display: none !important;
	}

	.sun-editor {
	  z-index: 9997;
	}

	.vuestic-simple-select .dropdown-menu {
		z-index: 9999;
	}

	.sun-editor .sun-editor-id-editorArea {
		min-height: 400px;
	}

  .sun-editor .sun-editor-id-editorArea,
  .sun-editor .sun-editor-id-editorArea > div {
    // color: black;
  }
</style>
