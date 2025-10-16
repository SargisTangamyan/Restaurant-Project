<script setup>

// VUE
import {ref, onMounted, watch} from 'vue'

// COMPONENTS
import ThePagination from '@/components/ui/ThePagination.vue'
import TheLoader from "@/components/ui/TheLoader.vue";
import ListTable from "@/components/ui/ListTable.vue";

// STORES
import { useCategoryStore } from '@/stores/index.js'

// USING STORE
const categoryStore = useCategoryStore()

// REACTIVE VARIABLES
const categories = ref([])
const pagination = ref({ current_page: 1, last_page: 1, per_page: 10, total: 1})
const isLoading = ref(false)

// WATCH
watch(
  () => categoryStore.getCategories,
  async () => {
    await getNewCategories(1, 10);
  }
);

// METHODS
const getNewCategories = async function (movePage, perPage=10, force = false) {
  isLoading.value = true;
  const res = await categoryStore.fetchCategories(movePage, perPage, force)
  if (res.success) {
    categories.value = res.categories;
    pagination.value = { ...categoryStore.getPagination };
  }
  isLoading.value = false;
}

const deleteCategory = async (id, arrayId) => {
  const res = await categoryStore.deleteCategory(id);
  categories.value.splice(arrayId, 1);
  console.log(res);
}

// MOUNTING
onMounted(() => {
  isLoading.value = true;
  getNewCategories();
  isLoading.value = false;
})
</script>

<template>
  <the-loader v-show="isLoading"/>
  <section class="lg:col-span-2 h-full">
    <h2 class="text-lg font-semibold mb-4 text-gray-700">All Categories</h2>

    <div class="overflow-x-auto">
      <list-table
        :header="['#', 'Name', 'Parent', 'Actions']"
        :center="['Actions']"
        :items="categories"
        :pagination="pagination"
        :loading="isLoading"
      >
        <template #row="{ item, index }">
          <td class="p-3 border-b font-medium">{{ item.name }}</td>
          <td class="p-3 border-b">
            {{ item.parent_id ? categoryStore.getParentCategories[item.parent_id] : 'root' }}
          </td>
          <td class="p-3 border-b text-center">
            <button class="text-blue-600 hover:underline">Edit</button> |
            <button
              @click.prevent="deleteCategory(item.id, index)"
              class="text-red-600 hover:underline"
            >
              Delete
            </button>
          </td>
        </template>
      </list-table>
      <the-pagination :current-page="pagination.current_page" :totalPages="pagination.last_page" @move-to="getNewCategories"></the-pagination>
    </div>
  </section>
</template>

<style scoped>

</style>
