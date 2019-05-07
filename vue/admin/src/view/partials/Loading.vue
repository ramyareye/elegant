<template>
  <div class="row d-flex justify-content-center">
  	<fingerprint-spinner
		  :animation-duration="1500"
		  :size="256"
		  :color="'#4ae387'"
		/>
  </div>
</template>

<script>
  import { FingerprintSpinner } from 'epic-spinners'
  export default {
    name: 'Loading',
    components: {
      FingerprintSpinner
    }
  }
</script>

<style lang="scss" scoped>
</style>
