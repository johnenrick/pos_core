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
          db_name: 'product.description',
          label_colspan: 5,
          clause: 'like'
        }
      }
      let columnSetting = {
        product_description: {
          db_name: 'product.description',
          name: 'Product Description',
          footer: {
            label: 'Total'
          }
        },
        quantity_adjustment_type_description: {
          db_name: 'quantity_adjustment_type.description',
          name: 'Type'
        },
        quantity: {
          data_type: 'number',
          footer: {
            formula: {
              total_quantity: 'sum(quantity)'
            }
          }
        },
        remarks: {},
        created_at: {
          name: 'Date Adjusted'
        }
      }
      let tableSetting = {
        filterSetting: filterSetting,
        columnSetting: columnSetting,
        retrieveParameter: {
          with_foreign_table: ['product', 'quantity_adjustment_type']
        }
      }
      let formSetting = {
        inputs: {
          product_id: {
            label: 'Product',
            input_type: 'select2',
            input_setting: {
              url: this.APIUrl('product/retrieve'),
              query_column: 'description',
              query_callback: (response) => {
                let options = []
                for(let x = 0; x < response.length; x++){
                  options.push({
                    id: response[x]['id'],
                    text: response[x]['description']
                  })
                }
                return options
              }
            }
          },
          quantity_adjustment_type_id: {
            label: 'Type',
            input_type: 'select2',
            input_setting: {
              url: this.APIUrl('quantity_adjustment_type/retrieve'),
              query_column: 'description',
              query_callback: (response) => {
                let options = []
                for(let x = 0; x < response.length; x++){
                  options.push({
                    id: response[x]['id'],
                    text: response[x]['description']
                  })
                }
                return options
              }
            }
          },
          quantity: {},
          remarks: {}
        }
      }
      return {
        api: 'product_quantity_adjustment',
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
