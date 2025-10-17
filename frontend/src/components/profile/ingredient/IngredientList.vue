<script setup>

// VUE
import {ref, onMounted, watch} from 'vue'

// COMPONENTS
import ThePagination from '@/components/ui/ThePagination.vue'
import TheLoader from "@/components/ui/TheLoader.vue";
import ListTable from "@/components/ui/table/ListTable.vue";
import TableColumn from "@/components/ui/table/TableColumn.vue";

// STORES
import { useIngredientStore } from '@/stores/index.js'

// USING STORE
const ingredientStore = useIngredientStore()

// REACTIVE VARIABLES
const ingredients = ref([])
const pagination = ref({ current_page: 1, last_page: 1, per_page: 10, total: 1})
const isLoading = ref(false)

// WATCH
watch(() => ingredientStore.getIngredients, () => {
  ingredients.value = ingredientStore.getIngredients;
})

// METHODS
const getNewIngredients = async function (movePage=1, perPage=10, force = false) {
  isLoading.value = true;
  const res = await ingredientStore.fetchIngredients(movePage, perPage, force)
  if (res.success) {
    ingredients.value = ingredientStore.getIngredients;
    pagination.value = ingredientStore.getPagination;
  }
  isLoading.value = false;
}

const deleteIngredient = async (id) => {
  const res = await ingredientStore.deleteIngredient(id);
  if (res.success) {
    console.log('Ingredient deleted')
  } else {
    console.log('Failed to delete ingredient')
  }
}

// MOUNTING
onMounted(async () => {
  isLoading.value = true;
  await getNewIngredients();
  isLoading.value = false;
})
</script>

<template>
  <the-loader v-show="isLoading"/>
  <section class="lg:col-span-2 h-full">
    <h2 class="text-lg font-semibold mb-4 text-gray-700">All Ingredients</h2>

    <div class="overflow-x-auto">
      <list-table
        :header="['#', 'Name', 'Unit', 'Price', 'Actions']"
        :center="['Actions']"
        :items="ingredients"
        :pagination="pagination"
        :loading="isLoading"
      >
        <template #row="{ item }">
          <table-column :element="item.name" />
          <table-column :element="item.unit" />
          <table-column :element="item.price" />
          <table-column class="text-center">
              <button class="text-blue-600 hover:underline">Edit</button> |
              <button
                @click.prevent="deleteIngredient(item.id)"
                class="text-red-600 hover:underline"
              >
                Delete
              </button>
          </table-column>
        </template>
      </list-table>
      <the-pagination :current-page="pagination.current_page" :totalPages="pagination.last_page" @move-to="getNewIngredients"></the-pagination>
    </div>
  </section>
</template>

<style scoped>

</style>
