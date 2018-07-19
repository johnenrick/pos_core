<template>
  <div>
    <input
      ref="input"
      v-if="form_status !== 'view' && !read_only"
      v-bind:name="input_name"
      v-bind:placeholder="placeholder"
      type="text"
      class="form-control text-right"
      v-bind:class="feedback_status_class"
      v-on:change="valueChanged"
      v-bind:value="form_data|getFormDataFilter(db_name, default_value)"
      >
    <span v-else class="form-control text-right">{{form_data|getFormDataFilter(db_name, default_value)}}&nbsp;</span>
  </div>
</template>
<script>
  export default{
    name: '',
    create(){

    },
    mounted(){
      this.defaultValue = this.default_value ? this.default_value : false
    },
    data(){
      return {
        defaultValue: false
      }
    },
    props: {
      input_setting: Object,
      default_value: [String, Number],
      db_name: String,
      input_name: String,
      field_name: String,
      form_data: Object,
      form_status: String,
      feedback_status_class: String,
      form_data_updated: Boolean,
      placeholder: String,
      read_only: Boolean
    },
    methods: {
      valueChanged(e){
        $(e.target).val()
        this.$emit('change', this.field_name, $(e.target).val())
      }
    }

  }
</script>
<style scoped>

</style>
