<script setup>
// VUE
import { defineProps, defineEmits} from 'vue'

// COMPONENTS
import ErrorMessage from "@/components/ui/form/ErrorMessage.vue"
import FormLabel from "@/components/ui/form/FormLabel.vue";

// EMITS
const emit = defineEmits(['update:modelValue'])

// PROPS
const props = defineProps({
  label: {
    type: String,
    required: true
  },
  inputType: {
    type: String,
    required: true
  },
  placeholder: {
    type: String,
    required: false,
    default: ''
  },
  modelValue: {
    type: [String, Number],
    required: true
  },
  errors: {
    type: Array,
    required: false,
    default: () => []
  },
  mb: {
    type: Boolean,
    required: false,
    default: true
  },
  min: [Number, String],
  max: [Number, String],
  step: [Number, String]
})

// METHODS
const updateInput = (event) => {
  let value = event.target.value;

  if (props.inputType === 'number') {
    value = Number(value)
    if (isNaN(value) || value < 0) {
      value = 0;
    }
  }
  emit('update:modelValue', value)
}

</script>

<template>
  <div :class="{'mb-4': mb}">
    <form-label :label="label" />
    <input
      :type="inputType"
      :placeholder="placeholder"
      class="input-outline w-full"
      :value="modelValue"
      @input="updateInput"
      :min="min"
      :max="max"
      :step="step"
    />
    <error-message
      v-for="(error, index) in errors"
      :key="index"
      :message="error"
    />
  </div>
</template>
