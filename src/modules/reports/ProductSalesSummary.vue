<template>
  <div>
    <module v-on:table_filter="tableFilter" :module_name="'Product Sales Summary'" :api="api" :api_setting="api_setting" :table_setting="table_setting" :form_setting="form_setting">
      <div slot="beforeTable">
        <bar-chart :data_set="dataSet"></bar-chart>
      </div>
    </module>
  </div>
</template>
<script>
  export default{
    name: '',
    components: {
      'module': require('components/common_module/CommonModule.vue'),
      'bar-chart': require('components/chart/BarChart.vue')
    },
    create(){

    },
    mounted(){

    },
    data(){
      let filterSetting = {
        description: {
          db_name: 'product.description',
          col: 4,
          label_colspan: 5,
          clause: 'like'
        },
        start_date_filter: {
          db_name: 'created_at',
          input_type: 'date',
          clause: '>=',
          label: 'Start Date',
          input_setting: {
            with_time: true
          }
        },
        end_date_filter: {
          db_name: 'created_at',
          input_type: 'date',
          clause: '<',
          label: 'End Date',
          input_setting: {
            time_setting: {
              default_time: '23:59:59'
            }
          }
        }
      }
      let columnSetting = {
        description: {
          name: 'Description',
          db_name: 'product.description'
        },
        total_quantity: {
          data_type: 'number'
        },
        total_sale_price: {
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
          price: {
            input_type: 'number',
            placeholder: '0.00'
          }
        }
      }
      return {
        api: 'order_product',
        api_setting: {
          retrieve: 'order_product/productSalesSummary'
        },
        table_setting: tableSetting,
        form_setting: formSetting,
        dataSet: []
      }
    },
    props: {
    },
    methods: {
      tableFilter: function(requestOption){
        while(this.dataSet.length > 0) { this.dataSet.pop() }
        this.APIRequest('order_product/productSalesSummary', requestOption, (response) => {
          if(response['data']){
            let tableEntries = response['data']
            for(let x = 0; x < tableEntries.length; x++){
              this.dataSet.push([tableEntries[x]['product']['description'], tableEntries[x]['total_quantity']])
            }
          }
          console.log(this.dataSet)
        })
      }
    }

  }
</script>
<style scoped>

</style>
