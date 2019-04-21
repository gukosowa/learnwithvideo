<template>
    <input :type="type ? type : 'text'"
           v-if="edit"
           style="background-color: rgb(50, 59, 76);
    box-shadow: rgb(17, 24, 38) 0px 0px 2px 1px inset;
    padding-left: 5px;
    border-radius: 5px; outline:none;-webkit-appearance: none; 
  margin: 0;"
           :style="inputStyle"
           :class="['fix', inputClass]"
           :value="valueLocal"
           @focus="$event.target.select()"
           @blur.prevent="valueLocal = $event.target.value; edit = false; $emit('input', valueLocal);"
           @keyup.enter.prevent="valueLocal = $event.target.value; edit = false; $emit('input', valueLocal);"
           v-focus=""
             />
        <span id="text" v-else="" style="min-width:20px; min-height:15px; display:inline-block" :style="(valueLocal == '' ? 'background-color:rgba(17, 22, 31, 0.74); border-radius:9px;' : '')" @click="edit = true;">
          {{valueLocal}}
        </span>
</template>

<script>
  export default {

  props: ['value', 'inputClass', 'inputStyle', 'type'],

  data () {
  return {
      edit: false,
      valueLocal: this.value,
    }
  },

  watch: {
    value: function() {
      this.valueLocal = this.value;
    }
  },

  directives: {
    focus: {
      inserted (el) {
        el.focus()
      }
    }
  }

}
</script>