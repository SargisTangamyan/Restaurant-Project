<script setup>

// VUE
import { ref } from 'vue'

// EMITS
const emit = defineEmits(['counterChange'])

// PROPS
const props = defineProps({
  counter: {
    required: false,
    type: Number,
    default: 1,
  }
});

// REF
const count = ref(props.counter);

// METHODS
const changeCounterBy = (number) => {
  count.value += number
  if (count.value < 1) {
    count.value = 1;
  }
  emit('counterChange', count.value);
}

</script>

<template>
  <div class="flex flex-col sm:flex-row gap-3">
    <div class="flex items-center border rounded-lg overflow-hidden w-fit">
      <button @click="changeCounterBy(-1)" class="px-3 py-2 cursor-pointer"><font-awesome-icon :icon="['fas', 'minus']"/></button>
      <input type="text" :value="count" class="w-12 text-center border-x border-gray-200">
      <button @click="changeCounterBy(1)" class="px-3 py-2 cursor-pointer"><font-awesome-icon :icon="['fas', 'plus']"/></button>
    </div>
  </div>
</template>

<style scoped>

</style>
