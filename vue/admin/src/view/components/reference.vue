<script>  
  export default {
    name: 'reference',
    
    // data () {
    //   return {
    //     name: '',
    //     url: ''
    //   }
    // },

    props: {
	    reference: {
	      type: Object,
	      required: true
	    }
	  },

    methods: {
    	del () {
    		this.$emit('del', this.reference)
    	}
    }
  }
</script>

<template>
  <div class="col-6">
  	<div class="row row-reverse">
		  <div class="col-4">
	      <div class="form-group with-icon-right"
	           :class="{'has-error': errors.has('name')}">
	        <div class="input-group">
	          <input
	            id="name"
	            name="name"
	            v-model="reference.name"
	          />
	          <i
	            class="fa fa-exclamation-triangle icon-right input-icon"
	            v-show="errors.has('name')"></i>
	          <label class="control-label" for="slug">{{'reference.name'
	            | translate}}</label><i class="bar"></i>
	          <small v-show="errors.has('name')"
	                 class="help text-danger">{{
	            errors.first('name')
	            }}
	          </small>
	        </div>
	      </div>
			</div>

			<div class="col-5">
	      <div class="form-group with-icon-right"
	           :class="{'has-error': errors.has('url')}">
	        <div class="input-group">
	          <input
	            id="url"
	            name="url"
	            v-model="reference.url"
	          />
	          <i
	            class="fa fa-exclamation-triangle icon-right input-icon"
	            v-show="errors.has('url')"></i>
	          <label class="control-label" for="url">{{'reference.url'
	            | translate}}</label><i class="bar"></i>
	          <small v-show="errors.has('url')"
	                 class="help text-danger">{{
	            errors.first('url')
	            }}
	          </small>
	        </div>
	      </div>
			</div>

			<div class="col-3 text-right">
			  <div class="btn btn-primary btn-with-icon btn-micro rounded-icon" @click="del">
	        <div class="btn-with-icon-content">
	          <i class="ion-md-close ion"></i>
	        </div>
	      </div>
	      <!-- <div class="btn btn-primary btn-with-icon btn-micro rounded-icon" @click="save">
	        <div class="btn-with-icon-content">
	          <i class="ion-md-checkmark-circle-outline ion"></i>
	        </div>
	      </div> -->
			</div>
		</div>
  </div>
</template>
