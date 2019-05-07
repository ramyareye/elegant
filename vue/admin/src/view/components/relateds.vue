<script>  
  import Related from './related'

  export default {
    name: 'relateds',

    props: {
      relateds: {
        type: Array,
        required: true
      }
    },

    components: {
      Related
    },

    methods: {
      add () {
        const next = {
          id: {},
          selector: 'name',
          type: {id: 'categories', name: 'Categories'}
        }

        this.relateds.push(next)
      },
      del (rel) {
        this.$emit('delRel', rel)
      },
      changeRelated ({old, changed}) {
        this.$emit('changeRel', {old, changed})
      }
    }
  }
</script>

<template>
	<div class="row row-reverse">
    <div class="col-12 mb-3 mt-3 text-center">
      <div class="btn btn-primary btn-with-icon btn-micro" @click="add">
        {{ $t('related.add') }}
      </div>
    </div>

    <related       
      @del="del"
      :related="rel"
      :key="index + 3"
      @change="changeRelated"
      v-for="(rel, index) in relateds"
    />
	</div>
</template>
