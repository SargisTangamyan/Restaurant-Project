<script setup>
import CategorySearch from "@/components/profile/category/CategorySearch.vue";
import FormInput from "@/components/ui/form/FormInput.vue";
import ErrorMessage from "@/components/ui/form/ErrorMessage.vue";
import FormBox from "@/components/ui/form/FormBox.vue";
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
  parentCategory.value.clearQuery();
}

const showErrors = function (errors) {
  if (errors.name) {
    nameErrors.value = errors.name;
  }
  if (errors.parent_id) {
    parentErrors.value = errors.parent_id;
  }
}

const clearErrors = function () {
  nameErrors.value = [];
  parentErrors.value = [];
}

const addCategory = async function() {
  if (invalidParent.value === true) return;
  const res = await categoryStore.addCategory({'name': cName.value, 'parent_id': parentId.value});
  if (res.success) {
    clearForm();
    await categoryStore.fetchCategories(1, 10, true);
    clearErrors();
  } else {
    showErrors(res.errors);
  }
}
</script>

<template>
  <form-box @form-submit="addCategory" button-text="Add Category" heading="Add Category">
    <template #inputs>
      <form-input v-model="cName" placeholder="e.g. Cakes" input-type="text" label="Category Name" :errors="nameErrors" />

      <category-search ref="parentCategory" @word-chosen="chooseParentId" @incorrect-word="blockSubmit" />
      <error-message v-for="(error, index) in parentErrors" :key="index" :message="error"/>
    </template>
  </form-box>
</template>

<style scoped>

</style>
