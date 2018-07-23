<template>
  <div>
    <module :api="api" :table_setting="table_setting" :form_setting="form_setting"></module>
  </div>
</template>
<script>
  export default{
    name: '',
    components: {
      'module': require('components/common_module/CommonModule.vue')
    },
    create(){

    },
    mounted(){

    },
    data(){
      let filterSetting = {
        description: {
          label_colspan: 5,
          clause: 'like'
        }
      }
      let columnSetting = {
        description: {
        },
        base_price: {
          type: 'decimal'
        },
        price_per_distance: {
          type: 'decimal'
        }
      }
      let tableSetting = {
        filterSetting: filterSetting,
        columnSetting: columnSetting
      }
      let formSetting = {
        inputs: {
          description: {
          },
          base_price: {
            input_type: 'number'
          },
          price_per_distance: {
            input_type: 'number'
          }
        }
      }
      return {
        api: 'bus_type',
        table_setting: tableSetting,
        form_setting: formSetting
      }
    },
    props: {
    },
    methods: {
    }

  }
</script>
<style scoped>

</style>
