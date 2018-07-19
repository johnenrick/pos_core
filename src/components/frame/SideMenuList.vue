<template>
  <li class="nav-item text-white" data-toggle="tooltip" data-placement="right" v-bind:title="StringPhraseToUnderscoreCase(name)">
    <template v-if="type === 'multi_level'">
      <a @click="menuClicked" class="nav-link nav-link-collapse collapsed " data-toggle="collapse" v-bind:href="'#' + StringPhraseToUnderscoreCase(name)">
        <i class="fa-wd fas" v-bind:class="icon"></i> <span class="nav-link-text">{{name}}</span>
      </a>

      <ul class="sidenav-second-level collapse" v-bind:id="StringPhraseToUnderscoreCase(name)">
        <template v-for="menu in subMenu" class="nav-item">
          <side-menu-list-recursive
            :type="menu['type']"
            :name="menu['name']"
            :icon="menu['icon']"
            :to="menu['to']"
            :sub_menu="menu['sub_menu']"
          ></side-menu-list-recursive>
        </template>
      </ul>
    </template>
    <template v-else-if="type === 'divider'">
      <h6 class="dropdown-header">{{name.toUpperCase()}}</h6>
    </template>
    <template v-else>
      <router-link v-bind:to="to" class="nav-link" active-class="active-link"  >
        <i class="fa-wd" v-bind:class="icon"></i>
        <span class="nav-link-text">{{name}}</span>
      </router-link>
    </template>
  </li>
</template>
<script>
  import Vue from 'vue'
  import ROUTER from '../../router'
  export default{
    name: '',
    components: {
    },
    beforeCreate: function () {
      this.$options.components.sideMenuListRecursive = require('./SideMenuList.vue')
    },
    create(){

    },
    mounted(){
      this.init()
    },
    data(){
      return {
        subMenu: [],
        currentRoute: this.$route
      }
    },
    props: {
      name: {
        default: null,
        type: String,
        required: false
      },
      icon: {
        default: null,
        type: String,
        required: false
      },
      to: {
        default: null,
        type: String,
        required: false
      },
      type: {
        default: null,
        type: String,
        required: false
      },
      sub_menu: {
        type: Array,
        default: () => {
          return []
        }
      }
    },
    methods: {
      init(){
        if(this.sub_menu.length){
          for(let x = 0; x < this.sub_menu.length; x++){
            let newSubMenu = {
              name: typeof this.sub_menu[x]['name'] !== 'undefined' ? this.sub_menu[x]['name'] : (this.sub_menu[x]['name'] ? this.sub_menu[x]['name'] : this.StringUnderscoreToPhrase(this.sub_menu[x]['to'])),
              icon: typeof this.sub_menu[x]['icon'] !== 'undefined' ? this.sub_menu[x]['icon'] : 'fas fa-dot-circle',
              to: typeof this.sub_menu[x]['to'] !== 'undefined' ? this.sub_menu[x]['to'] : '',
              type: typeof this.sub_menu[x]['type'] !== 'undefined' ? this.sub_menu[x]['type'] : null,
              sub_menu: typeof this.sub_menu[x]['sub_menu'] !== 'undefined' ? this.sub_menu[x]['sub_menu'] : []
            }
            this.subMenu.push(newSubMenu)
          }
        }
      },
      menuClicked(){
        $('.nav-link.nav-link-collapse:not(".collapsed")').trigger('click')
      }
    }

  }
</script>
<style scoped>
.hidden{
  display: none
}

</style>
