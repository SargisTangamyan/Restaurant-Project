<script setup>

// VUE
import {ref, onMounted} from 'vue'

// COMPONENTS
import ThePagination from '@/components/ui/ThePagination.vue'
import TheLoader from "@/components/ui/TheLoader.vue";

// STORES
import { useCategoryStore } from '@/stores/index.js'

// USING STORE
const categoryStore = useCategoryStore()

// METHODS
const getNewCategories = async function (movePage) {
  isLoading.value = true;
  const res = await categoryStore.fetchCategories(movePage, 10, true)
  if (res.success) {
    categories.value = res.categories;
    pagination.value = categoryStore.getPagination;
  }
  isLoading.value = false;
}

// reactive variable for categories
const categories = ref([])
const pagination = ref({ current_page: 1, last_page: 1, per_page: 10, total: 1 })
const isLoading = ref(false)

const deleteCategory = async (id, arrayId) => {
  const res = await categoryStore.deleteCategory(id);
  categories.value.splice(arrayId, 1);
  console.log(res);
}

onMounted(async () => {
  isLoading.value = true;
  const res = await categoryStore.fetchCategories()
  if (res.success) {
    categories.value = res.categories;
    pagination.value = categoryStore.getPagination;
  }
  isLoading.value = false;
})
</script>

<template>
  <the-loader v-show="isLoading"/>
  <section class="lg:col-span-2">
    <h2 class="text-lg font-semibold mb-4 text-gray-700">All Categories</h2>

    <div class="overflow-x-auto">
      <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
        <thead class="bg-gray-100">
        <tr class="text-left text-gray-700 text-sm">
          <th class="p-3 border-b">#</th>
          <th class="p-3 border-b">Name</th>
          <th class="p-3 border-b">Parent</th>
          <th class="p-3 border-b text-center">Actions</th>
        </tr>
        </thead>
        <tbody>
        <!-- Example rows -->
        <tr v-for="(category, index) in categories" :key="category.id" class="hover:bg-gray-50 text-sm text-gray-600">
          <td class="p-3 border-b">{{ (pagination.current_page - 1) * pagination.per_page + index + 1 }}</td>
          <td class="p-3 border-b font-medium">{{category.name}}</td>
          <td class="p-3 border-b">{{category.parent_id ?? 'root'}}</td>
          <td class="p-3 border-b text-center">
            <button class="text-blue-600 hover:underline">Edit</button> |
            <button @click.prevent="deleteCategory(category.id, arrayId)" class="text-red-600 hover:underline">Delete</button>
          </td>
        </tr>
        </tbody>
      </table>
      <the-pagination :current-page="pagination.current_page" :totalPages="pagination.last_page" @move-to="getNewCategories"></the-pagination>
    </div>
  </section>
</template>

<style scoped>

</style>
