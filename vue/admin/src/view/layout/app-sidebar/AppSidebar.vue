<template>
  <vuestic-sidebar :hidden="isOpen">
    <template slot="menu">

      <template v-for="(item, index) in menuItems">

        <sidebar-link
          v-if="!item.children && showItem(item)"
          :to="{name: item.name}"
          >
          <span slot="title">
            <span
              class="sidebar-menu-item-icon" v-bind:class="item.meta.iconClass"></span>
            <span>{{ $t(item.meta.title) }}</span>
          </span>
        </sidebar-link>

        <sidebar-link-group
          v-else-if="showItem(item)">
          <span slot="title">
            <span
              class="sidebar-menu-item-icon" v-bind:class="item.meta.iconClass"></span>
            <span>{{ $t(item.meta.title) }}</span>
          </span>
          <sidebar-link 
            v-if="!childItem.meta.hidden && showItem(childItem)"
            :key="childItem.name"
            :to="{name: childItem.name}"
            v-for="childItem in item.children">
            <span slot="title">
              <span>{{ $t(childItem.meta.title) }}</span>
            </span>
          </sidebar-link>
        </sidebar-link-group>
      </template>

    </template>
  </vuestic-sidebar> 
</template>

<script>
import {mapGetters, mapActions} from 'vuex'
import VuesticSidebar
  from 'vuestic-theme/vuestic-components/vuestic-sidebar/VuesticSidebar'
import SidebarLink from './components/SidebarLink'
import SidebarLinkGroup from './components/SidebarLinkGroup'

export default {
    name: 'app-sidebar',
    components: {
      VuesticSidebar,
      SidebarLink,
      SidebarLinkGroup
    },
    props: {
      isOpen: {
        type: Boolean,
        required: true
      }
    },
    computed: {
      ...mapGetters({
        'menuItems': 'menuItems',
        'permissions': 'permissions'
      })
    },
    methods: {
      showItem (item) {
        let flag = false

        item.meta.per.split(':').map(i => {
          if (this.permissions.includes(i)) flag = true
        })

        return flag
      }
    }
  }

</script>
