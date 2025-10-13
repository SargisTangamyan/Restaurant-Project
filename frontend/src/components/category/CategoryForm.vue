<script setup>
import CategorySearch from "@/components/category/CategorySearch.vue";
import { ref } from 'vue';
import { useCategoryStore } from '@/stores/index.js'

const categoryStore = useCategoryStore();

const parentId = ref(null);
const cName = ref('');

const chooseParentId = function (id)
{
  parentId.value = id;
  console.log(id);
}

const addCategory = async function() {
  const res = await categoryStore.addCategory({'name': cName.value, 'parent_id': parentId.value});
  console.log(res);
}
</script>

<template>
  <section class="bg-gray-50 border border-gray-200 rounded-xl p-5">
    <h2 class="text-lg font-semibold mb-4 text-gray-700">Add Category</h2>

    <form class="flex flex-col gap-4">
      <div>
        <label class="block text-sm text-gray-600 mb-1">Category Name</label>
        <input type="text" placeholder="e.g. Cakes"
               class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
          v-model="cName"
        >
      </div>

      <category-search @word-chosen="chooseParentId"/>

      <button type="submit"
              class="button-cgreen w-full"
              :disabled="!parentId"
              @click.prevent="addCategory"
      >
        Add Category
      </button>
    </form>
  </section>
</template>

<style scoped>

</style>
