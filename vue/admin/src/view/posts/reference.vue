<script>
  import dataInput from 'view/components/data-input'
  
  export default {
    name: 'reference',
    data () {
      return {
        name: '',
        url: ''
      }
    },
    methods: {
      updateInput ({field, value}) {
        this[field] = value
      },
      add () {
        // if (_.isEmpty(this.category)) {
        //   this.$store.dispatch('addToastMessage', { text: this.$t('errors.category') })
        // } else {
        //   this.$validator.validateAll().then((result) => {
        //     if (result) {
        //       const data = {
        //         title: this.title,
        //         excerpt: this.excerpt,
        //         visible: this.visible,
        //         body: this.editor.getContents(),
        //         category: this.category.id
        //       }
              
        //       api.post('posts', data).then(response => {
        //         this.$store.dispatch('addToastMessage',
        //           { text: this.$t('post.created'), type: 'success' }
        //         )

        //         this.$router.push({ name: 'post', params: { id: response.data.id } })
        //       }).catch(error => {
        //         this.$store.dispatch('addToastMessage',
        //           { text: this.$t('errors.any'), error }
        //         )
        //       })
        //     }
        //   })
        // }
      }
    }
  }
</script>

<template>
	<div class="row">
		<div class="col">
		  <data-input
		    :field="'name'"
		    :name="'name'"
		    :validation="'required'"
		    :val="name"
		    @update="updateInput"
		    :placeholder="'category.reference.name' | translate"
		  />
		</div>

		<div class="col">
		  <data-input
		    :field="'url'"
		    :name="'url'"
		    :validation="'required'"
		    :val="url"
		    @update="updateInput"
		    :placeholder="'category.reference.url' | translate"
		  />
		</div>

		<div class="col">
		  <button class="btn btn-success"  @click="save">
        {{'buttons.submit' | translate}}
      </button>

		  <div class="btn btn-primary btn-with-icon btn-micro rounded-icon">
		  	<div class="btn-with-icon-content">
		  		<i class="ion-md-cloud-outline ion"></i>
		  	</div>
		  </div>
		</div>
	</div>
</template>
