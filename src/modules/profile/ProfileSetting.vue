<template>
  <div class="content-padding">
    <div class="row">
      <div class="col-md-7 ">
        <h2>Profile Setting</h2>
        <hr>
        <common-form ref="form" :api="'account'" :no_create="true" :no_delete="true" :retrieve_parameter="retrieveParameter" :inputs="inputSetting"></common-form>
      </div>
    </div>
  </div>
</template>
<script>
  export default{
    name: '',
    components: {
      'common-form': require('../../components/form/CommonForm.vue')
    },
    create(){

    },
    mounted(){
      this.$refs.form.viewForm(this.$auth.user().id)
    },
    data(){
      return {
        retrieveParameter: {
          with_foreign_table: ['account_information', 'account_type']
        },
        inputSetting: {
          basic_information: {
            title: 'Basic Information',
            input_type: 'group',
            inputs: {
              username: {
                read_only: true
              },
              'account_information.id': {
                input_type: 'hidden'
              },
              'account_information.first_name': {
                label: 'First Name'
              },
              'account_information.middle_name': {
                label: 'Middle Name'
              },
              'account_information.last_name': {
                label: 'Last Name'
              }
            }
          },
          password_section: {
            title: 'Security',
            input_type: 'group',
            inputs: {
              password: {
                input_type: 'secret'
              },
              verify_password: {
                input_type: 'secret'
              }
            }
          }
        }
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
