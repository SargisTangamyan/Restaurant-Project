<script setup>
// VUE
import { ref, watch } from 'vue';
import { useRoute } from 'vue-router';

// EMITS
const emit = defineEmits(['reachedEnd', 'addFilter', 'removeFilter']);

// PROPS
const props = defineProps({
  filters: {
    type: Array,
    required: true,
  },
  type: {
    type: String,
    required: true,
  }
});

// ROUTE
const route = useRoute();

// REFS
const filterList = ref(null);

// EVENT HANDLERS
const onScroll = () => {
  const el = filterList.value;
  if (el && el.scrollTop + el.clientHeight >= el.scrollHeight) {
    emit('reachedEnd');
  }
};

const toggleFilter = (event, id, name) => {
  if (event.target.checked) {
    emit('addFilter', id, name);
  } else {
    emit('removeFilter', id, name);
  }
};

// WATCHERS
watch(
  () => route.query[props.type],
  (newQuery) => {
    // When the route query changes, uncheck checkboxes that are no longer in it
    const selectedIds = (newQuery || '')
      .split(',')
      .filter((x) => x); // remove empty

    // Iterate through all checkboxes and uncheck those not in route
    const checkboxes = filterList.value?.querySelectorAll('input[type="checkbox"]') || [];
    checkboxes.forEach((checkbox) => {
      const id = checkbox.id.replace('filter-', '');
      checkbox.checked = selectedIds.includes(id);
    });
  }
);
</script>

<template>
  <ul
    ref="filterList"
    @scroll="onScroll"
    class="p-0 m-0 max-h-64 overflow-y-auto"
  >
    <li
      v-for="filter in filters"
      :key="filter.id"
      class="mb-4"
    >
      <div class="flex items-center gap-4">
        <input
          @change="toggleFilter($event, filter.id, filter.name)"
          class="w-4 h-4"
          type="checkbox"
          :id="'filter-' + filter.id"
          name="filter"
        />
        <label
          class="leading-none flex items-center justify-between w-full"
          :for="'filter-' + filter.id"
        >
          <span class="block">{{ filter.name }}</span>
        </label>
      </div>
    </li>
  </ul>
</template>
