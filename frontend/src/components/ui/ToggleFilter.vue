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
  filters: {
    type: Array,
    required: true,
  }
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
          <div
            class="relative flex items-center border border-gray-400 border-box rounded-sm overflow-hidden mb-4">
            <input
              type="search"
              placeholder="Search ..."
              class="flex-1 py-2 px-3 pr-10 outline-none placeholder-gray-400"
            />
            <font-awesome-icon
              :icon="['fas', 'magnifying-glass']"
              class="absolute right-3 text-md text-gray-500 pl-1 border-l border-gray-400"
            />
          </div>

          <ul class="p-0 m-0">
            <li v-for="(filter, id) in props.filters" :key="id" class="mb-4">
              <div class="flex items-center gap-4">
                <input class="w-4 h-4" type="checkbox" name="filter">
                <label class="leading-none flex items-center justify-between w-full" for="fruit">
                  <span class="block">{{ filter.name }}</span>
                  <span class="block text-sm text-gray-400">({{ filter.count }})</span>
                </label>
              </div>
            </li>
          </ul>
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
