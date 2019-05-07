<script>
  import Vue from 'vue'
  import api from 'src/packages/Api'  
  import Multiselect from 'vue-multiselect'
  
  export default {
    name: 'multi-select',

    data () {
      return {
        loading: false,
        value: [],
        request_sent: false
      }
    },

    props: {
      select: {
        type: [Object, Array],
        required: true
      },
      selects: {
        type: Array,
        required: true
      },
      apiUrl: {
        type: String,
        default: '',
        required: false
      },
      searchable: {
        type: Boolean,
        default: true
      },
      placeholder: {
        type: String,
        default: Vue.i18n.translate('vuetable.search')
      },
      title: {
        type: String,
        default: 'name'
      },
      selector: {
        type: String,
        default: 'id'
      },
      no_result: {
        type: String,
        default: Vue.i18n.translate('custom.not_found')
      },
      rtl: {
        type: Boolean,
        default: false
      },
      multiple: {
        type: Boolean,
        default: false
      }
    },

    components: {
      Multiselect
    },

    mounted () {
      this.value = this.select
    },

    methods: {
      find (keyword) {
        if (this.apiUrl !== '') {
          if (this.request_sent || keyword.length < 3) return

          this.loading = true
          this.request_sent = true

          api.post(this.apiUrl, { keyword })
            .then(response => {
              this.$emit('search', response.data)

              this.loading = false
              this.request_sent = false
            }).catch(error => {
              // error
              this.loading = false
              this.request_sent = false
            })
        } else {          
          this.$emit('search', keyword)
        }   
      },
      addTag (tag) {
        const t = {
          id: tag,
          name: tag
        }

        this.value.push(t)
      }
    },
    watch : {
      value (value) {
        this.$emit('select', value)
      }
    }
  }
</script>

<template>
  <div :dir="rtl ? 'rtl' : 'ltr'">
    <multiselect
      v-model="value"
      :options="selects"
      :searchable="searchable"
      :loading="loading" 
      @search-change="find"
      :placeholder="placeholder"
      :label="title"
      :track-by="selector"
      @tag="addTag"
      :taggable="true"
      :multiple="true"
      :tag-placeholder="placeholder"
    >
      <span slot="noResult">{{ no_result }}</span>

        <!-- <multiselect v-model="selectedCountries" id="ajax" label="name" track-by="code" placeholder="Type to search" open-direction="bottom" :options="countries" :multiple="true" :searchable="true" :loading="isLoading" :internal-search="false" :clear-on-select="false" :close-on-select="false" :options-limit="300" :limit="3" :limit-text="limitText" :max-height="600" :show-no-results="false" :hide-selected="true" @search-change="asyncFind"> -->
    </multiselect>
  </div>
</template>

<style lang="scss">
  @import '~vue-multiselect/dist/vue-multiselect.min.css';

  .multiselect {
    z-index: 100000;
  }
</style>