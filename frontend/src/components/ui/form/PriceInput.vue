<script setup>

// VUE
import { ref, defineProps, watch, defineEmits, defineExpose } from 'vue';

// COMPONENTS
import FormInput from '@/components/ui/form/FormInput.vue';

// REFS
const price = ref(0);
const priceErrors = ref([]);

// EMIT
const emit = defineEmits(['update:modelValue'])

// METHODS
const clearInput = () => {price.value = 0}
const clearErrors = () => {priceErrors.value = []}
const showErrors = (errors) => {priceErrors.value = errors}

const validate = function () {
  if (price.value < 0)
  {
    showErrors(['Price cannot be negative'])
    return false;
  }
  return true;
}

// PROPS
const props = defineProps({
  modelValue: {
    type: Number,
    required: true
  },
  mb: {
    required: false,
    type: Boolean,
    default: true,
  }
})

// WATCH
watch(() => props.modelValue, (val) => price.value = val)
watch(price, (val) => emit('update:modelValue', val))

// EXPOSE FUNCTION
defineExpose({
  validate,
  clearInput,
  clearErrors,
  showErrors
});

</script>

<template>
  <form-input v-model="price" step="any" input-type="number" label="Price" :errors="priceErrors" :min="0" :mb="mb"/>
</template>

<style scoped>

</style>
