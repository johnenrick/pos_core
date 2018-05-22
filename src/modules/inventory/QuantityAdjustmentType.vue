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
        description: {},
        type: {
          value_function: (entry) => {
            return entry['type'] * 1 === 1 ? 'Deduction' : 'Addition'
          }
        },
        remarks: {}
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
              options: [
                {id: 1, text: 'Deduction'},
                {id: 2, text: 'Addition'}
              ]
            }
          },
          remarks: {}
        }
      }
      return {
        api: 'quantity_adjustment_type',
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
