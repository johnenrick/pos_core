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
          db_name: 'ingredient.description',
          label_colspan: 5,
          clause: 'like'
        }
      }
      let columnSetting = {
        description: {
          db_name: 'ingredient.description',
          name: 'Description'
        },
        quantity: {},
        created_at: {
          name: 'Date Supplied'
        }
      }
      let tableSetting = {
        filterSetting: filterSetting,
        columnSetting: columnSetting,
        retrieveParameter: {
          with_foreign_table: ['ingredient']
        }
      }
      let formSetting = {
        inputs: {
          ingredient_id: {
            label: 'Ingredient',
            input_type: 'select2',
            input_setting: {
              url: this.APIUrl('ingredient/retrieve'),
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
          quantity: {}
        }
      }
      return {
        api: 'ingredient_supply',
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
