<template>
  <div class="language-dropdown" v-if="false">
    <span
      class="flag-icon flag-icon-large"
      :class="flagIconClass(currentLanguage())"
    />
    <vuestic-dropdown
      class="language-dropdown__container"
      v-model="isShown"
      position="bottom"
    >
      <a class="dropdown-item"
         v-for="(option, id) in options"
         :key="id"
         :class="{ active: option.locale === currentLanguage() }"
         @click="setLanguage(option.locale)"
      >
        <span class="flag-icon flag-icon-small" :class="flagIconClass(option.code)"></span>
        <span class="dropdown-item__text ellipsis">
          {{ `language.${option.name}` | translate }}
        </span>
      </a>
    </vuestic-dropdown>
  </div>
</template>

<script>
import Vue from 'vue'

export default {
  name: 'language-dropdown',
  data () {
    return {
      isShown: false,
    }
  },
  props: {
    options: {
      type: Array,
      default: () => [
        {
          code: 'gb',
          locale: 'en',
          name: 'english',
        },
        {
          code: 'ir',
          locale: 'fa',
          name: 'persian',
        }
      ],
    },
  },
  methods: {
    setLanguage (locale) {
      this.isShown = false

      Vue.i18n.set(locale)
    },

    currentLanguage () {
      const locale = this.options.find(o => o.locale == Vue.i18n.locale())

      return locale.code
    },

    flagIconClass (code) {
      return `flag-icon-${code}`
    },
  },
}
</script>

<style lang="scss">
@import '~vuestic-theme/vuestic-sass/resources/resources';
@import "~flag-icon-css/css/flag-icon.css";

.language-dropdown {
  @include flex-center();
  cursor: pointer;
  .flag-icon-large {
    display: block;
    width: 31px;
    height: 23px;
  }

  @at-root {
    &__container {
      .flag-icon-small {
        min-width: 22px;
        height: 17px;
        margin-right: 12px;
      }
    }
  }
}
</style>
