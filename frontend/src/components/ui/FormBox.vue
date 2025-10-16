<script setup>

// VUE
import { defineProps, defineEmits} from 'vue'

const props = defineProps({
  heading: {
    required: true,
    type: String,
  },
  buttonText: {
    required: true,
    type: String,
  }
})

const emits = defineEmits(['formSubmit'])

</script>

<template>
  <section class="bg-gray-50 border border-gray-200 rounded-xl p-5 h-fit">
    <h2 class="text-lg font-semibold mb-4 text-gray-700">{{ props.heading }}</h2>

    <form @submit.prevent="emits('formSubmit')" class="flex flex-col gap-4">

    <slot name="inputs" />

      <button type="submit"
              class="button-cgreen w-full"
      >
        {{ props.buttonText }}
      </button>
    </form>
  </section>
</template>

<style scoped>

</style>
