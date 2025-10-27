<script setup>
import { ref, computed, defineEmits } from 'vue';
import { useCategoryStore, useMessageStore } from '@/stores/index.js';
import CategorySearch from '@/components/profile/category/CategorySearch.vue';
import FormInput from '@/components/ui/form/FormInput.vue';
import ErrorMessage from '@/components/ui/form/ErrorMessage.vue';
import FormBox from '@/components/ui/form/FormBox.vue';

// Emits
const emits = defineEmits(['category-created']);

// Stores
const categoryStore = useCategoryStore();
const messageStore = useMessageStore();

// Form state
const categoryName = ref('');
const parentId = ref(null);
const parentCategoryRef = ref(null);

// Validation state
const nameErrors = ref([]);
const parentErrors = ref([]);
const generalError = ref('');
const isSubmitting = ref(false);

// Success message
const successMessage = ref('');

// Computed
const isFormValid = computed(() => {
  return categoryName.value.trim() !== '' && !isSubmitting.value;
});

/**
 * Handle parent category selection
 */
const handleParentSelect = (id) => {
  parentId.value = id;
  parentErrors.value = [];
};

/**
 * Handle invalid parent selection
 */
const handleInvalidParent = () => {
  parentId.value = null;
  parentErrors.value = ['Please select a valid parent category or leave empty'];
};

/**
 * Clear all form fields
 */
const clearForm = () => {
  categoryName.value = '';
  parentId.value = null;
  if (parentCategoryRef.value) {
    parentCategoryRef.value.clearQuery();
  }
  clearErrors();
  successMessage.value = '';
};

/**
 * Display validation errors
 */
const showErrors = (errors) => {
  nameErrors.value = [];
  parentErrors.value = [];
  generalError.value = '';

  if (errors.name) {
    nameErrors.value = Array.isArray(errors.name) ? errors.name : [errors.name];
  }
  if (errors.parent_id) {
    parentErrors.value = Array.isArray(errors.parent_id) ? errors.parent_id : [errors.parent_id];
  }
  if (errors.general) {
    generalError.value = Array.isArray(errors.general) ? errors.general[0] : errors.general;
  }
};

/**
 * Clear all errors
 */
const clearErrors = () => {
  nameErrors.value = [];
  parentErrors.value = [];
  generalError.value = '';
};

/**
 * Validate form locally before submission
 */
const validateForm = () => {
  clearErrors();
  let isValid = true;

  if (!categoryName.value.trim()) {
    nameErrors.value = ['Category name is required'];
    isValid = false;
  }

  if (categoryName.value.trim().length > 255) {
    nameErrors.value = ['Category name must not exceed 255 characters'];
    isValid = false;
  }

  return isValid;
};

/**
 * Submit form to create category
 */
const addCategory = async () => {
  if (!validateForm()) {
    return;
  }

  isSubmitting.value = true;
  clearErrors();

  try {
    const payload = {
      name: categoryName.value.trim(),
      parent_id: parentId.value || null
    };

    const res = await categoryStore.addCategory(payload);

    if (res.success) {
      // Show success message using message store
      messageStore.showMessage('Category created successfully!', 'success');

      // Clear form
      clearForm();

      // Refresh categories list
      await categoryStore.fetchCategories(1, 10, true);

      // Emit event
      emits('category-created', res.category);
    } else {
      showErrors(res.errors || { general: ['Failed to create category'] });
    }
  } catch (error) {
    showErrors({ general: [error.message || 'An unexpected error occurred'] });
  } finally {
    isSubmitting.value = false;
  }
};
</script>

<template>
  <form-box
    @form-submit="addCategory"
    button-text="Add Category"
    heading="Add New Category"
  >
    <template #inputs>
      <!-- General Error -->
      <error-message
        v-if="generalError"
        :message="generalError"
        class="mb-4"
      />

      <!-- Category Name Input -->
      <form-input
        v-model="categoryName"
        class="pb-0"
        placeholder="e.g. Cakes, Desserts, Main Course"
        input-type="text"
        label="Category Name"
        :errors="nameErrors"
        :disabled="isSubmitting"
      />

      <!-- Parent Category Search -->
      <div class="mt-4">
        <category-search
          ref="parentCategoryRef"
          @word-chosen="handleParentSelect"
          @incorrect-word="handleInvalidParent"
          :disabled="isSubmitting"
        />
        <error-message
          v-for="(error, index) in parentErrors"
          :key="index"
          :message="error"
        />
        <p class="text-xs text-gray-500 mt-1">
          Optional: Select a parent category to create a subcategory
        </p>
      </div>

      <!-- Loading State -->
      <div v-if="isSubmitting" class="text-center text-sm text-gray-600 mt-2">
        Creating category...
      </div>
    </template>
  </form-box>
</template>
