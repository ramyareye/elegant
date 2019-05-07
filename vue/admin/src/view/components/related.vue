<script>  
  import _ from 'lodash'
	import Multiselect from 'view/components/multiselect'

  export default {
    name: 'related',

    data () {
    	return {  
        mounted: false,
    		apiUrl: 'categories/search',
    		types: [
	    		{
	    			id: 'categories',
	    			name: this.$t('related.type_categories'),
	    			selector: 'name'
	    		},
	    		{
	    			id: 'blogs',
	    			name: this.$t('related.type_blogs'),
	    			selector: 'title'
	    		},
	    		{
	    			id: 'questions',
	    			name: this.$t('related.type_questions'),
	    			selector: 'title'
	    		},
	    		{
	    			id: 'videos',
	    			name: this.$t('related.type_videos'),
	    			selector: 'title'
	    		}
	    	],
        relations: []
    	}
    },

    props: {
	    related: {
	      type: Object,
	      required: true
	    }
	  },

	  components: {
      Multiselect
    },

    mounted () {
      if (!_.isEmpty(this.related.id)) {
        this.relations.push(this.related.id)
      }
    },

    methods: {
    	del () {
    		this.$emit('del', this.related)
    	},

    	findRelations (relations) {
        this.relations = relations
      },

      selectRelated (related) {
        if (related !== undefined) {

          this.$emit('change', {
          	old: this.related, 
          	changed: { 
          		id: related,
          		type: this.related.type,
              selector: this.related.selector
          	}
          })
        }        
      },

      selectType (type) {
        if (this.mounted && type !== undefined) {
          this.mounted = true
        	this.apiUrl = `${type.id}/search`

          this.$emit('change', {
          	old: this.related, 
          	changed: { 
          		id: {},
          		type,
              selector: type.selector
          	}
          })
        }

        this.mounted = true      
      }
    }
  }
</script>

<template>
  <div class="col-6 mb-2">
  	<div class="row row-reverse">
		  <div class="col-4">
		  	<multiselect
          :select="related.type"
          :selects="types"
          :rtl="true" 
          @select="selectType"
          :placeholder="'related.type' | translate"
        />		  	
      </div>

			<div class="col-5">
	      <multiselect
	      	:rtl="true" 
	      	:title="related.selector"
	      	:apiUrl="apiUrl"
          :select="related.id"
          :selects="relations"
          @search="findRelations"
          @select="selectRelated"
          :placeholder="'related.id' | translate"
        />
			</div>

			<div class="col-3 text-right">
			  <div class="btn btn-primary btn-with-icon btn-micro rounded-icon" @click="del">
	        <div class="btn-with-icon-content">
	          <i class="ion-md-close ion"></i>
	        </div>
	      </div>
			</div>
		</div>
  </div>
</template>