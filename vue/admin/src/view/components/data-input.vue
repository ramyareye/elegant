<template>
  <div 
    v-if="['text', 'number', 'email'].includes(field)"
  	class="form-group with-icon-right"
    :class="{'has-error': errors.has(name)}"
  >
    <div class="input-group">
      <input
        :id="name"
        :name="name"
        :type="field"
        v-model="dataInput"
        v-validate="validation"
        :required="required"
        data-vv-validate-on="change"
      />
      <i 
        class="fa fa-exclamation-triangle icon-right input-icon"
        v-show="errors.has(name)"
      ></i>
      
      <label class="control-label" :for="name">
	      {{ placeholder }}
	    </label>

	    <i class="bar"></i>
      
      <small v-show="errors.has(name)" class="help text-danger">
      	{{ errors.first(name) }}
      </small>
    </div>
  </div>
</template>

<script>
  export default {
  	name: 'data-input',

    inject: ['$validator'],

    data () {
    	return {
        dataInput: ''
  	  }
    },

    props: {
      field: {
        type: String,
        default: 'text'
      },
      name: {
        type: String,
        default: 'name'
      },
      validation: {
        type: String,
        default: ''
      },
      val: {
        type: ''
      },
      placeholder: {
        type: String,
        default: ''
      },
      selector: {
        type: String,
        default: ''
      }
    },

    computed: {
    	required () {
    		return this.validation.includes('required')
    	}
    },

    created () {
      this.dataInput = this.val

      this.update()
    },

    methods: {
      update () {
        const emit = { 
          field: this.name, 
          value: this.dataInput, 
          selector: this.selector
        }

        this.$emit('update', emit)
      }
    },

    watch: {
      dataInput: function (val) {        
        if (val !== '') this.$validator.validate()

        this.update()
      }
    }
  }
</script>
