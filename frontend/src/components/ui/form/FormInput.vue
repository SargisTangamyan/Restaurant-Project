<script setup>

// VUE
import {defineProps, defineEmits} from 'vue';

// COMPONENTS
import ErrorMessage from "@/components/ui/form/ErrorMessage.vue";

// PROPS
const props = defineProps({
  label: {
    required: true,
    type: String,
  },
  inputType: {
    required: true,
    type: String,
  },
  placeholder: {
    required: false,
    type: String,
  },
  modelValue: {
    required: true,
    type: [String, Number],
  },
  errors: {
    required: false,
    type: Array,
  }
});

const updateInput = function (event) {
  const value = props.inputType === 'number' ? +event.target.value : event.target.value;
  emit('update:modelValue', value);
}

const emit = defineEmits(['update:modelValue'])
</script>

<template>
  <label class="block text-sm text-gray-600 mb-1 mt-4">{{ label }}</label>
  <input :type="inputType" :placeholder="placeholder ?? ''"
         class="input-outline"
         :value="modelValue"
         @input="updateInput"
  >
  <error-message v-for="(error, index) in errors" :key="index" :message="error"/>
</template>

<style scoped>

</style>
