<template>
  <div>
    <module :api="api" :table_setting="table_setting" :form_setting="form_setting" :module_name="module_name"></module>
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
        id: {
          lalbel: 'Transaction Code',
          label_colspan: 5
        },
        customer: {
          label_colspan: 5,
          clause: 'like'
        }
      }
      let columnSetting = {
        id: {
        },
        customer: {
          value_function: (entry) => {
            return 'Juan Dela Cruz'
          }
        },
        total_price: {},
        status: {
          data_type: 'html',
          value_function: (entry) => {
            switch(entry['status'] * 1){
              case 0:
                return '<span class="badge badge-pill badge-dark">Draft</span>'
              case 1:
                return '<span class="badge badge-pill badge-success">Finished</span>'
              case 2:
                return '<span class="badge badge-pill badge-primary">Pending Online Payment</span>'
            }
          }
        }

      }
      let tableSetting = {
        filterSetting: filterSetting,
        columnSetting: columnSetting
      }
      let formSetting = {
        inputs: {
          parent_id: {},
          description: {},
          icon: {},
          path: {},
          rank: {
            input_type: 'select',
            input_setting: {
              options: [
                {
                  value: null,
                  label: 'Select Rank'
                },
                {
                  value: 1,
                  label: 'One'
                },
                {
                  value: 2,
                  label: 'Two'
                },
                {
                  value: 3,
                  label: 'Three'
                },
                {
                  value: 4,
                  label: 'Four'
                },
                {
                  value: 5,
                  label: 'Five'
                }
              ]
            }
          }
        }
      }
      return {
        module_name: 'Transaction History',
        api: 'order',
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
