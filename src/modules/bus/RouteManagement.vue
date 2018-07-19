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
        estimated_travel_duration: {
          data_type: 'number'
        }
      }
      let tableSetting = {
        filterSetting: filterSetting,
        columnSetting: columnSetting
      }
      let formSetting = {
        inputs: {
          description: {},
          estimated_travel_duration: {
            muted_text: 'The time it would take to travel from the starting and end location in MINUTES',
            input_type: 'number',
            default_value: 0
          },
          route_stops: {
            label_colspan: 12,
            input_type: 'table_input',
            input_setting: {
              action: {
                sortable: true
              },
              column_setting: {
                name: {},
                distance: {
                  input_type: 'number',
                  tool_tip: 'The distance from previous route',
                  name: 'Distance'
                }
              }
            }
          }
        }
      }
      return {
        api: 'route',
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
