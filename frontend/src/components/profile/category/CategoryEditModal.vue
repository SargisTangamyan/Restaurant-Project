
<script setup>
import { ref, watch, defineProps, defineEmits } from 'vue';
import { useCategoryStore } from '@/stores/index.js';
import CategorySearch from '@/components/profile/category/CategorySearch.vue';
import FormInput from '@/components/ui/form/FormInput.vue';
import ErrorMessage from '@/components/ui/form/ErrorMessage.vue';

// Props
const props = defineProps({
  category: {
    type: Object,
    default: null
  },
  show: {
    type: Boolean,
    default: false
  }
});

// Emits
const emits = defineEmits(['close', 'updated']);

// Store
const categoryStore = useCategoryStore();

// Form state
const categoryName = ref('');
const parentId = ref(null);
const parentCategoryRef = ref(null);

// Validation state
const nameErrors = ref([]);
const parentErrors = ref([]);
const generalError = ref('');
const isSubmitting = ref(false);

// Watch for category changes
watch(() => props.category, (newCategory) => {
  if (newCategory) {
    categoryName.value = newCategory.name || '';
    parentId.value = newCategory.parent_id || null;
  }
}, { immediate: true });

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
  parentErrors.value = ['Please select a valid parent category'];
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
 * Validate form locally
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

  // Check if trying to set itself as parent
  if (parentId.value && parentId.value === props.category?.id) {
    parentErrors.value = ['A category cannot be its own parent'];
    isValid = false;
  }

  return isValid;
};

/**
 * Submit form to update category
 */
const updateCategory = async () => {
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

    const res = await categoryStore.updateCategory(props.category.id, payload);

    if (res.success) {
      emits('updated', res.category);
      closeModal();
    } else {
      showErrors(res.errors || { general: ['Failed to update category'] });
    }
  } catch (error) {
    showErrors({ general: [error.message || 'An unexpected error occurred'] });
  } finally {
    isSubmitting.value = false;
  }
};

/**
 * Close modal
 */
const closeModal = () => {
  clearErrors();
  emits('close');
};
</script>

<template>
  <!-- Modal Overlay -->
  <transition name="modal">
    <div
      v-if="show"
      class="fixed inset-0 z-50 flex items-center justify-center bg-gray-200 bg-opacity-50 p-4"
      @click.self="closeModal"
    >
      <!-- Modal Content -->
      <div class="bg-white rounded-xl shadow-xl max-w-lg w-full max-h-[90vh] overflow-y-auto">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200">
          <h2 class="text-xl font-semibold text-gray-800">Edit Category</h2>
          <button
            @click="closeModal"
            class="text-gray-400 hover:text-gray-600 transition-colors"
            :disabled="isSubmitting"
          >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
        </div>

        <!-- Modal Body -->
        <form @submit.prevent="updateCategory" class="p-6 space-y-4">
          <!-- General Error -->
          <error-message
            v-if="generalError"
            :message="generalError"
            class="mb-4"
          />

          <!-- Category Name Input -->
          <form-input
            v-model="categoryName"
            placeholder="e.g. Cakes, Desserts"
            input-type="text"
            label="Category Name"
            :errors="nameErrors"
            :disabled="isSubmitting"
          />

          <!-- Parent Category Search -->
          <div>
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
              Optional: Select a parent category. Leave empty for root category.
            </p>
          </div>

          <!-- Modal Footer -->
          <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
            <button
              type="button"
              @click="closeModal"
              class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors"
              :disabled="isSubmitting"
            >
              Cancel
            </button>
            <button
              type="submit"
              class="px-4 py-2 text-white bg-cgreen rounded-lg hover:bg-cgreen transition-colors disabled:bg-gray-400 disabled:cursor-not-allowed"
              :disabled="isSubmitting"
            >
              {{ isSubmitting ? 'Updating...' : 'Update Category' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </transition>
</template>

<style scoped>
/* Modal transition animations */
.modal-enter-active,
.modal-leave-active {
  transition: opacity 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
  opacity: 0;
}

.modal-enter-active > div,
.modal-leave-active > div {
  transition: transform 0.3s ease;
}

.modal-enter-from > div,
.modal-leave-to > div {
  transform: scale(0.9);
}
</style>
