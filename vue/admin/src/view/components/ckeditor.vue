<template>
	<ckeditor :editor="editor"></ckeditor>
</template>

<script>
	import CKEditor from '@ckeditor/ckeditor5-vue';
	import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
	
  export default {
    name: 'ckeditor',
    components: {
      // Use the <ckeditor> component in this view.
      ckeditor: CKEditor.component
    },
    data () {
      return {
      	editor: ClassicEditor
      }
    },
    destroyEditor () {
      // this.editor.destroy()
    }
  }
</script>

<style lang="scss">
</style>
