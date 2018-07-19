<template>
  <div>
    <div v-if="data_type === 'number'" class="number">
      {{value*1}}
    </div>
    <div v-else-if="data_type === 'decimal'" class="number">
      {{formatNumber((value*1).toFixed(2))}}
    </div>
    <div v-else-if="data_type === 'html'" v-html="value">
    </div>
    <div v-else-if="data_type === 'boolean'" class="text-center">
      <i v-if="value === 0" class="fas fa-minus text-secondary"></i>
      <i v-if="value === 1" class="fas fa-check text-success"></i>
      <i v-else-if="value === 2" class="fas fa-times text-danger"></i>
    </div>
    <div v-else-if="data_type === 'check'" class="text-center">
      <i v-if="value * 1 === 0" class="fa fa-close text-danger" aria-hidden="true"></i>
      <i v-else class="fa fa-check text-success" aria-hidden="true"></i>
    </div>
    <div v-else-if="data_type === 'button'" >
      <button v-if="if_condition(row_data)" @click="setting['on_click']($event, row_data, row_index)" v-html="setting['label']" v-bind:class="setting['class']" @click.stop type="button" class="btn"></button>
    </div>
    <div v-else-if="data_type === 'multiple-button'" >
      <template v-for="button in setting['buttons']">
          <button v-if="button.if_condition(row_data)" @click="button.on_click($event, row_data, row_index)" v-html="button['label']" v-bind:class="button['class']"  @click.stop type="button" class="btn ml-2 mb-2"></button>
      </template>
    </div>
    <div v-else>
      {{value}}
    </div>
  </div>
</template>
<script>
  export default{
    name: '',
    create(){
    },
    mounted(){
    },
    data(){
      return {
      }
    },
    props: ['data_type', 'value', 'setting', 'row_data', 'if_condition', 'row_index'],
    methods: {
    }
  }
</script>
<style scoped>
  .number{
    text-align: right
  }
</style>
