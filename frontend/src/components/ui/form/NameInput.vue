<script setup>
import { ref, watch, defineProps, defineExpose, defineEmits } from 'vue'
import FormInput from '@/components/ui/form/FormInput.vue'

const emit = defineEmits(['update:modelValue'])

const props = defineProps({
  modelValue: {
    type: String,
    required: true
  },
  label: { type: String, required: true },
  placeholder: { type: String, default: '' },
  mb: { type: Boolean, default: true }
})

const name = ref(props.modelValue)
const nameErrors = ref([])

watch(() => props.modelValue, (val) => name.value = val)

const clearInput = () => { name.value = '' }
const clearErrors = () => { nameErrors.value = [] }
const showErrors = (errors) => { nameErrors.value = errors }

const validate = function () {
  if (name.value.length === 0) {
    showErrors(['Name cannot be empty'])
    return false
  }
  return true
}

watch(name, (val) => emit('update:modelValue', val))

defineExpose({
  validate,
  clearInput,
  clearErrors,
  showErrors
})
</script>

<template>
  <form-input
    v-model="name"
    input-type="text"
    :label="label"
    :placeholder="placeholder"
    :errors="nameErrors"
    :mb="mb"
  />
</template>
