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
      let type = ['Percent', 'Amount', 'Variable Percentage', 'Variable Amount']
      let application = ['Per Item', 'Per Transaction', 'Both']
      this.commonModuleOptionize
      let filterSetting = {
        description: {
          label_colspan: 5,
          clause: 'like'
        }
      }
      let columnSetting = {
        description: {},
        type: {
          value_function: (entry) => {
            return type[entry['type'] - 1]
          }
        },
        application: {
          value_function: (entry) => {
            return application[entry['application'] - 1]
          }
        },
        value: {
          default_value: 'N/A'
        }
      }
      let tableSetting = {
        filterSetting: filterSetting,
        columnSetting: columnSetting
      }
      let formSetting = {
        inputs: {
          description: {},
          type: {
            input_type: 'select',
            input_setting: {
              options: this.commonModuleOptionizeArray(type, null, 'Select Type')
            }
          },
          application: {
            input_type: 'select',
            input_setting: {
              options: this.commonModuleOptionizeArray(application, null, 'Select Application')
            }
          },
          value: {
            input_type: 'number'
          },
          restricted: {
            input_type: 'hidden',
            default_value: 0
          }
        }
      }
      return {
        api: 'discount',
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
