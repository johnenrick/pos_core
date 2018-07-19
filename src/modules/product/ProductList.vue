<template>
  <div>
    <module :module_name="'Product List'" :api="api" :table_setting="table_setting" :form_setting="form_setting"></module>
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
          label_colspan: 6,
          clause: 'like'
        },
        product_category_id: {
          label: 'Category',
          label_colspan: 5,
          clause: 'like',
          input_type: 'select',
          input_setting: {
            api: 'product_category/retrieve',
            api_option_text_column: 'description',
            default_text: 'All',
            default_id: null
          }
        }
      }
      let columnSetting = {
        description: {},
        short_name: {},
        category: {
          name: 'Category',
          db_name: 'product_category.description'
        },
        price: {
          data_type: 'decimal'
        }
      }
      let tableSetting = {
        filterSetting: filterSetting,
        columnSetting: columnSetting
      }
      let formSetting = {
        inputs: {
          description: {},
          short_name: {},
          product_category_id: {
            label: 'Category',
            input_type: 'select',
            input_setting: {
              api: 'product_category/retrieve',
              api_option_text_column: 'description',
              default_text: 'All',
              default_id: null
            }
          },
          price: {
            input_type: 'number',
            placeholder: '0.00'
          }
        }
      }
      return {
        api: 'product',
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
