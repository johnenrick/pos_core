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
        parent_id: {
          label_colspan: 5
        },
        description: {
          label_colspan: 5,
          clause: 'like'
        }
      }
      let columnSetting = {
        username: {
        },
        full_name: {
          value_function: (entry) => {
            return (entry['account_information']) ? entry['account_information']['first_name'] + ' ' + entry['account_information']['last_name'] : 'None'
          }
        },
        'account_type.description': {
          name: 'Account Type'
        },
        status: {
          data_type: 'html',
          value_function: (entry) => {
            return entry['status'] * 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">In Active</span>'
          }
        }
      }
      let tableSetting = {
        filterSetting: filterSetting,
        columnSetting: columnSetting,
        retrieveParameter: {
          with_foreign_table: ['account_type', 'account_information']
        }
      }
      let formSetting = {
        retrieveParameter: {
          with_foreign_table: ['account_type', 'account_information']
        },
        inputs: {
          username: {},
          password: {},
          'account_information.id': {
            input_type: 'hidden'
          },
          'account_information.first_name': {
            label: 'First Name'
          },
          'account_information.last_name': {
            label: 'Last Name'
          },
          email: {},
          account_type_id: {
            label: 'Type',
            input_type: 'text',
            input_setting: {
              api: 'account_type/retrieve',
              api_option_text_column: 'description'
            },
            default_value: 1
          },
          status: {
            input_type: 'select',
            input_setting: {
              options: [
                {id: '1', text: 'Active'},
                {id: '0', text: 'In Active'}
              ]
            }
          }
        }
      }
      return {
        api: 'account',
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
