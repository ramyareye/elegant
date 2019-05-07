<script>  
  import Reference from './reference'

  export default {
    name: 'references',
    
    // data () {
    //   return {
    //     name: '',
    //     url: '',
    //     references: []
    //   }
    // },

    props: {
      references: {
        type: Array,
        required: true
      }
    },

    components: {
      Reference
    },

    methods: {
      add () {
        const next = {
          name: '',
          url: ''
        }

        this.references.push(next)
      },
      del (reff) {
        this.$emit('delRef', reff)        
      }
    }
  }
</script>

<template>
	<div class="row row-reverse">
    <div class="col-12 mb-3 mt-3 text-center">
      <div class="btn btn-primary btn-with-icon btn-micro" @click="add">
        {{ $t('category.reference.add') }}
      </div>
    </div>

    <reference 
      v-for="(ref, index) in references" 
      :reference="ref" 
      @del="del"
      :key="index + 3"
    />
	</div>
</template>
