<template>
  <div class="form-elements">
    <div class="row">
      <div class="col-md-12">
        <div class="vuestic-widget">
          <div class="vuestic-widget-header">{{ title }}</div>
          <div class="vuestic-widget-body">
          	<slot></slot>
          </div>        
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
	name: 'body-widget',

	inject: ['$validator'],

	props: {
    title: {
      type: String,
      default: ''
    }
  }
}

</script>
