<script setup>
import { defineProps } from 'vue'

// COMPONENTS
import TableColumn from "@/components/ui/table/TableColumn.vue";

defineProps({
  /**
   * Table header labels
   * Example: ['#', 'Name', 'Parent', 'Actions']
   */
  header: {
    type: Array,
    required: true,
  },
  center: {
    type: Array,
    required: false,
    default: () => [],
  },
  /**
   * Table data (array of objects)
   */
  items: {
    type: Array,
    required: true,
  },
  /**
   * Pagination data (optional)
   */
  pagination: {
    type: Object,
    default: () => ({ current_page: 1, per_page: 10 }),
  },
  /**
   * Whether the table should show a loading state
   */
  loading: {
    type: Boolean,
    default: false,
  },
})
</script>

<template>
  <div class="relative overflow-x-auto">
    <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
      <thead class="bg-gray-100">
      <tr class="text-left text-gray-700 text-sm">
        <th
          v-for="(title, index) in header"
          :key="index"
          :class="{'text-center': center.includes(title)}"
          class="p-3 border-b whitespace-nowrap"
        >
          {{ title }}
        </th>
      </tr>
      </thead>

      <tbody v-if="!loading && items.length">
      <tr
        v-for="(item, index) in items"
        :key="item.id ?? index"
        class="hover:bg-gray-50 text-sm text-gray-600"
      >
        <!-- default index column -->
        <table-column
            :element="(pagination.current_page - 1) * pagination.per_page + index + 1"
       />

        <!-- default content slot for each row -->
        <slot name="row" :item="item" :index="index"></slot>
      </tr>
      </tbody>

      <!-- Empty state -->
      <tbody v-else-if="!loading && !items.length">
      <tr>
        <td :colspan="header.length" class="text-center text-gray-500 py-6">
          No data found.
        </td>
      </tr>
      </tbody>

      <!-- Loading state -->
      <tbody v-else>
      <tr>
        <td :colspan="header.length" class="text-center py-6 text-gray-500">
          Loading...
        </td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<style scoped>
</style>
