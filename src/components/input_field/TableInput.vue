<template>
  <div>
    <table class="table table-responsive-md">
      <thead>
        <tr>
          <th v-for="(column, index) in columnSetting[0]"
            v-bind:rowspan="(column['sub_columns']) ? 1:2"
            v-bind:colspan="column['sub_columns'] ? column['sub_column_count']  : 1"
          >
            {{column['name']}}
            <i v-if="column['tool_tip']" class="fas fa-question-circle" data-toggle="tooltip" data-placement="top" v-bind:title="column['tool_tip']"></i>
            <!--<span class="pull-right">
              <i v-if="column['sort'] === 0" class="fa fa-sort" aria-hidden="true"></i>
              <i v-else-if="column['sort'] === 1" class="fa fa-sort-asc" aria-hidden="true"></i>
              <i v-else-if="column['sort'] === 2" class="fa fa-sort-desc" aria-hidden="true"></i>
            </span>-->
          </th>
          <th v-if="action['remove_entry']"></th>
        </tr>
        <tr>
          <th v-for="(column, index) in columnSetting[1]"
            v-bind:rowspan="(column['sub_columns']) ? 1:2"
            v-bind:colspan="column['sub_columns'] ? column['sub_column_count']  : 1"
          >
            {{column['name']}}

            <!---<span class="pull-right">
              <i v-if="column['sort'] === 0" class="fa fa-sort" aria-hidden="true"></i>
              <i v-else-if="column['sort'] === 1" class="fa fa-sort-asc" aria-hidden="true"></i>
              <i v-else-if="column['sort'] === 2" class="fa fa-sort-desc" aria-hidden="true"></i>
            </span>-->
          </th>
        </tr>
      </thead>
      <tbody ref="tableBody">
        <tr v-for="(tableEntry, index) in tableEntries"
          @click="$emit('row_clicked', index, tableEntry['id'])"
        >
          <input type="hidden" v-bind:name="db_name + '[' + index + '][id]'" v-bind:value="tableEntry['id']">
          <td v-for="(columnSetting, columnIndex) in linearColumnSetting">
            <template v-if="form_status !== 'view'">
              <select v-if="columnSetting['input_type'] === 'select'"
                v-bind:value="(tableEntry[columnSetting['db_name']] || columnSetting['default_value'])"
                class="form-control"
                v-bind:class="error_list[db_name + '.' + index + '.' + columnSetting['db_name']] ? 'is-invalid' : ''"

                v-bind:name="db_name + '[' + index + '][' + columnSetting['db_name'] + ']'"
              >
                <option v-for="option in columnSetting['input_setting']['options']" v-bind:value="option['value']" v-bind:selected="(tableEntry[columnSetting['db_name']] || columnSetting['default_value'])  === option['value'] ? 'selected' : false">{{option['label']}}</option>
              </select>
              <input v-else-if="columnSetting['input_type'] === 'number'"
                class="form-control text-right"
                v-bind:class="error_list[db_name + '.' + index + '.' + columnSetting['db_name']] ? 'is-invalid' : ''"
                v-model="tableEntry[columnSetting['db_name']]"
                v-bind:name="db_name + '[' + index + '][' + columnSetting['db_name'] + ']'"
              >
              <input v-else
                class="form-control"
                v-bind:class="error_list[db_name + '.' + index + '.' + columnSetting['db_name']] ? 'is-invalid' : ''"

                v-model="tableEntry[columnSetting['db_name']]"
                v-bind:name="db_name + '[' + index + '][' + columnSetting['db_name'] + ']'"
              >

              <div class="invalid-feedback">{{db_name + '.' + columnIndex + '.' + columnSetting['db_name']}}
                {{(error_list[db_name + '.' + columnIndex + '.' + columnSetting['db_name']]) ? error_list[db_name + '.' + columnIndex + '.' + columnSetting['db_name']] : ''}}
              </div>
            </template>
            <span v-else class="form-control" v-bind:class="columnSetting['input_type'] === 'number' ? 'text-right': ''">
              {{tableEntry[columnSetting['db_name']]}}
            </span>
          </td>
          <td v-if=" hasAction && form_status !== 'view'">
            <div class="btn-group" role="group" aria-label="Basic example">
              <button v-if="action['sortable']" @click="move(index, tableEntry['id'], 'up')" class="btn btn-sm btn-link" type="button"><i class="fas fa-arrow-up" aria-hidden="true"></i></button>
              <button v-if="action['sortable']" @click="move(index, tableEntry['id'], 'down')" class="btn btn-sm btn-link" type="button"><i class="fas fa-arrow-down" aria-hidden="true"></i></button>
              <button v-if="action['remove_entry']" @click="removeEntry(index, tableEntry['id'])" class="btn btn-sm btn-danger" type="button"><i class="fas fa-trash" aria-hidden="true"></i></button>
            </div>

          </td>
        </tr>
      </tbody>
      <tfoot>
        <tr >
          <td v-bind:colspan="columnCount +( action['add_entry'] ? 1 : 0)">
            <button v-if="form_status !== 'view'" @click="addEntry" type="button" class="btn btn-sm btn-primary pull-right"><i class="fas fa-plus" aria-hidden="true"></i> Add</button>
          </td>
        </tr>
      </tfoot>
    </table>
    <input v-for="(id, index) in deletedForeignTable"
      v-bind:value="id"
      v-bind:name="'deleted_foreign_table['+db_name+']['+index+']'"
      type="hidden"
    >
  </div>
</template>
<script>
  import Vue from 'vue'
  export default{
    name: '',
    create(){

    },
    mounted(){
      this.initConfig()
      this.initColumnSetting()

    },
    data(){
      return {
        columnSetting: [
          [],
          []
        ],
        linearColumnSetting: [],
        tableEntries: [],
        currentSort: null,
        hasAction: true,
        action: {
          add_entry: true,
          remove_entry: true,
          sortable: false
        },
        columnCount: 0,
        deletedForeignTable: []
      }
    },
    props: {
      form_data_updated: Boolean,
      input_setting: Object,
      default_value: String,
      db_name: String,
      form_data: Object,
      form_status: String,
      placeholder: String,
      error_list: Object,
      read_only: Boolean
    },
    watch: {
      form_data_updated(value){
        this.tableEntries = this.form_data[this.db_name] ? this.form_data[this.db_name] : []
        this.deletedForeignTable = []
      },
      form_status(newValue){
        console.log(newValue)
        if(newValue !== 'view'){
          // $(this.$refs.tableBody).sortable({
          //   appendTo: 'parent',
          //   helper: 'clone'
          // }).disableSelection()
        }else{
          // $(this.$refs.tableBody).sortable('disable')
        }
      }
    },
    methods: {
      addEntry(){
        let newEntry = {
          id: 0
        }
        for(let x = 0; x < this.linearColumnSetting.length; x++){
          newEntry[this.linearColumnSetting[x]['db_name']] = null
        }
        this.tableEntries.push(newEntry)
      },
      initColumnSetting(){
        let columnSetting = this.input_setting['column_setting']
        for(let dbName in columnSetting){
          this.columnCount++
          let column = columnSetting[dbName]
          Vue.set(column, 'db_name', typeof column['db_name'] !== 'undefined' ? column['db_name'] : dbName)
          Vue.set(column, 'tool_tip', typeof column['tool_tip'] !== 'undefined' ? column['tool_tip'] : null)
          this.initColumn(column)
          this.columnSetting[0].push(column)
          if(!column['sub_columns']){
            this.linearColumnSetting.push(column)
          }else{
            let subCount = 0
            for(let subColDBName in column['sub_columns']){
              subCount++
              let subColumn = column['sub_columns'][subColDBName]
              Vue.set(subColumn, 'db_name', subColDBName)
              this.initColumn(subColumn)
              this.columnSetting[1].push(subColumn)
              this.linearColumnSetting.push(subColumn)
            }
            Vue.set(column, 'sub_column_count', subCount)
          }
        }
      },
      initConfig(){
        if(typeof this.input_setting['action'] !== 'undefined'){
          this.hasAction = true
          for(let action in this.input_setting['action']){
            this.action[action] = this.input_setting['action']
          }
        }
      },
      initColumn(column){
        typeof column['name'] === 'undefined' ? Vue.set(column, 'name', this.StringUnderscoreToPhrase(column['db_name'])) : null
        typeof column['type'] === 'undefined' ? Vue.set(column, 'type', 'text') : null
        typeof column['sort'] === 'undefined' ? Vue.set(column, 'sort', 0) : null
        typeof column['value_function'] === 'undefined' ? Vue.set(column, 'value_function', (row, dbName) => {
          let dbNameSegment = dbName.split('.')
          let value
          if(dbNameSegment.length > 1){
            value = row
            for(let x = 0; x < dbNameSegment.length; x++){
              if(typeof value[dbNameSegment[x]] !== 'undefined'){
                value = value[dbNameSegment[x]]
              }else{
                break
              }
            }
          }else{
            value = row[dbName]
          }
          return value
        }) : null
        typeof column['sub_columns'] === 'undefined' ? Vue.set(column, 'sub_columns', null) : null
      },
      removeEntry(rowIndex, entryID){
        if(entryID){
          this.deletedForeignTable.push(entryID)
          console.log(this.tableEntries)
          this.tableEntries.splice(rowIndex, 1)
          console.log(this.tableEntries)
        }
      },
      move(index, id, direction){
        if(direction === 'up' && index > 0){
          this.tableEntries.splice(index - 1, 0, this.tableEntries.splice(index, 1)[0])
        }else if(direction === 'down' && index < this.tableEntries.length - 1){
          this.tableEntries.splice(index + 1, 0, this.tableEntries.splice(index, 1)[0])
          // this.tableEntries = this.moveArray(this.tableEntries, index, index + 1)
        }
        let newArray = this.tableEntries.slice()
        while(this.tableEntries.length > 0) this.tableEntries.pop()
        for(let x = 0; x < newArray.length; x++) this.tableEntries.push(newArray[x])
        // console.log(this.tableEntries)

      }
    }

  }
</script>
<style scoped>

</style>
