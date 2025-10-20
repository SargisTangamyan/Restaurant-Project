<script setup>

// VUE
import {defineProps, ref} from 'vue';

// FONT AWESOME
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";

// COMPONENTS
import UnderlinedText from "@/components/ui/UnderlinedText.vue";
import FilterBox from "@/components/filter/FilterBox.vue";

// PROPS
const props = defineProps({
  name: {
    type: String,
    required: true,
  },
})

// REFS
const filterWindowOpen = ref(false);

// METHODS
const toggleShowBox = function () {
  filterWindowOpen.value = !filterWindowOpen.value;
}

</script>

<template>
  <filter-box>
    <template #header>
      <h2 class="w-full text-xl font-bold text-gray-800">
        <button @click="toggleShowBox"
                class="w-full flex items-center justify-between cursor-pointer" type="button">
          <underlined-text :name="props.name"></underlined-text>
          <font-awesome-icon v-if="filterWindowOpen" class="block" :icon="['fas', 'caret-up']"/>
          <font-awesome-icon v-else class="block" :icon="['fas', 'caret-down']"/>
        </button>
      </h2>
    </template>

    <template #default>
      <transition name="reveal">
        <div v-if="filterWindowOpen">
          <slot />
        </div>
      </transition>
    </template>
  </filter-box>
</template>

<style scoped>
.reveal-enter-active,
.reveal-leave-active {
  transition: clip-path 0.3s ease, opacity 0.3s ease;
}

.reveal-enter-from,
.reveal-leave-to {
  clip-path: inset(0 0 100% 0); /* hidden from bottom */
  opacity: 0;
}

.reveal-enter-to,
.reveal-leave-from {
  clip-path: inset(0 0 0 0); /* fully shown */
  opacity: 1;
}
</style>
