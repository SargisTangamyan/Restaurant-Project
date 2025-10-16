<script setup>
import CategorySearch from "@/components/category/CategorySearch.vue";
import ErrorMessage from "@/components/ui/ErrorMessage.vue";
import FormBox from "@/components/ui/FormBox.vue";
import { ref } from 'vue';
import { useCategoryStore } from '@/stores/index.js'

const categoryStore = useCategoryStore();

const parentId = ref(null);
const cName = ref('');

const parentCategory = ref(null);
const invalidParent = ref(false);

const nameErrors = ref([]);
const parentErrors = ref([]);

const chooseParentId = function (id)
{
  parentId.value = id;
  invalidParent.value = false;
}

const blockSubmit = function() {
  invalidParent.value = true;
  parentId.value = null;
}

const clearForm = function () {
  cName.value = '';
  parentCategory.value.resetParentCategory();
}

const showErrors = function (errors) {
  if (errors.name) {
    nameErrors.value = errors.name;
  }
  if (errors.parent_id) {
    parentErrors.value = errors.parent_id;
  }
}

const addCategory = async function() {
  if (invalidParent.value === true) return;
  const res = await categoryStore.addCategory({'name': cName.value, 'parent_id': parentId.value});
  if (res.success) {
    clearForm();
    console.log('success');
    await categoryStore.fetchCategories(1, 10, true);
  } else {
    showErrors(res.errors);
  }
}
</script>

<template>
  <form-box @form-submit="addCategory" button-text="Add Category" heading="Add Category">
    <template #inputs>
      <div>
        <label class="block text-sm text-gray-600 mb-1">Category Name</label>
        <input type="text" placeholder="e.g. Cakes"
               class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-green-600"
          v-model="cName"
        >
        <error-message v-for="(error, index) in nameErrors" :key="index" :message="error"/>
      </div>

      <category-search ref="parentCategory" @word-chosen="chooseParentId" @incorrect-word="blockSubmit" />
      <error-message v-for="(error, index) in parentErrors" :key="index" :message="error"/>
    </template>
  </form-box>
</template>

<style scoped>

</style>
