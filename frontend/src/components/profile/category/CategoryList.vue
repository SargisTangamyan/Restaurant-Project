<script setup>
import { ref, onMounted, watch, computed } from 'vue';
import { useCategoryStore, useMessageStore } from '@/stores/index.js';
import ThePagination from '@/components/ui/ThePagination.vue';
import TheLoader from '@/components/ui/TheLoader.vue';
import ListTable from '@/components/ui/table/ListTable.vue';
import TableColumn from '@/components/ui/table/TableColumn.vue';
import CategoryEditModal from '@/components/profile/category/CategoryEditModal.vue';
import ConfirmDialog from '@/components/ui/ConfirmDialog.vue';

// Stores
const categoryStore = useCategoryStore();
const messageStore = useMessageStore();

// State
const categories = ref([]);
const pagination = ref({
  current_page: 1,
  last_page: 1,
  per_page: 10,
  total: 0
});
const isLoading = ref(false);

// Edit modal state
const showEditModal = ref(false);
const editingCategory = ref(null);

// Computed
const hasCategories = computed(() => categories.value.length > 0);

/**
 * Watch for category store changes
 */
watch(
  () => categoryStore.getCategories,
  async () => {
    await fetchCategories(pagination.value.current_page, pagination.value.per_page);
  }
);

/**
 * Fetch categories with pagination
 */
const fetchCategories = async (page = 1, perPage = 10, force = false) => {
  isLoading.value = true;

  try {
    const res = await categoryStore.fetchCategories(page, perPage, force);

    if (res.success) {
      categories.value = res.categories;
      pagination.value = { ...categoryStore.getPagination };
    }
  } catch (error) {
    messageStore.showMessage('Failed to fetch categories', 'error');
    console.error('Failed to fetch categories:', error);
  } finally {
    isLoading.value = false;
  }
};

/**
 * Get parent category name
 */
const getParentName = (parentId) => {
  if (!parentId) return 'Root';
  return categoryStore.getParentCategories[parentId] || 'Unknown';
};

/**
 * Open edit modal
 */
const openEditModal = (category) => {
  editingCategory.value = { ...category };
  showEditModal.value = true;
};

/**
 * Close edit modal
 */
const closeEditModal = () => {
  showEditModal.value = false;
  editingCategory.value = null;
};

/**
 * Handle category updated
 */
const handleCategoryUpdated = async () => {
  await fetchCategories(pagination.value.current_page, pagination.value.per_page, true);
  messageStore.showMessage('Category updated successfully', 'success');
  closeEditModal();
};

/**
 * Confirm and delete category
 */
const confirmDelete = async (category) => {
  try {
    await messageStore.showConfirm({
      title: 'Delete Category',
      message: `Are you sure you want to delete "${category.name}"? This action cannot be undone.`,
      confirmText: 'Delete',
      cancelText: 'Cancel',
      type: 'danger',
      onConfirm: async () => {
        await deleteCategory(category.id);
      }
    });
  } catch (error) {
    console.error('Delete cancelled or failed:', error);
  }
};

/**
 * Delete category
 */
const deleteCategory = async (categoryId) => {
  try {
    const res = await categoryStore.deleteCategory(categoryId);

    if (res.success) {
      messageStore.showMessage('Category deleted successfully', 'success');

      // Refresh if needed
      if (categories.value.length === 1 && pagination.value.current_page > 1) {
        await fetchCategories(pagination.value.current_page - 1, pagination.value.per_page, true);
      } else {
        await fetchCategories(pagination.value.current_page, pagination.value.per_page, true);
      }
    } else {
      messageStore.showMessage(
        res.error.join("\n") || 'Failed to delete category. It may have subcategories or associated dishes.',
        'error'
      );
    }
  } catch (error) {
    messageStore.showMessage('An error occurred while deleting the category', 'error');
    console.error('Delete error:', error);
    throw error; // Re-throw to be caught by confirm dialog
  }
};

/**
 * Handle pagination change
 */
const handlePageChange = (page) => {
  fetchCategories(page, pagination.value.per_page);
};

/**
 * Refresh categories
 */
const refreshCategories = async () => {
  await fetchCategories(pagination.value.current_page, pagination.value.per_page, true);
  messageStore.showMessage('Categories refreshed', 'info');
};

// Lifecycle
onMounted(async () => {
  await fetchCategories();
});
</script>

<template>
  <section class="lg:col-span-2 h-full">
    <!-- Header with refresh button -->
    <div class="flex justify-between items-center mb-4">
      <h3 class="text-lg font-semibold text-gray-700">Categories List</h3>
      <button
        @click="refreshCategories"
        :disabled="isLoading"
        class="px-3 py-1 text-sm text-cgreen border border-cgreen rounded-lg hover:bg-green-50 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
      >
        <span v-if="!isLoading">↻ Refresh</span>
        <span v-else>Loading...</span>
      </button>
    </div>

    <!-- Loading Overlay -->
    <the-loader v-show="isLoading" />

    <!-- Table -->
    <div class="overflow-x-auto">
      <list-table
        :header="['#', 'Name', 'Slug', 'Parent', 'Actions']"
        :center="['Actions']"
        :items="categories"
        :pagination="pagination"
        :loading="isLoading"
      >
        <template #row="{ item, index }">
          <!-- Category Name -->
          <table-column>
            <span class="font-medium text-gray-800">{{ item.name }}</span>
          </table-column>

          <!-- Category Slug -->
          <table-column>
            <code class="text-xs bg-gray-100 px-2 py-1 rounded">{{ item.slug }}</code>
          </table-column>

          <!-- Parent Category -->
          <table-column>
            <span
              class="text-sm"
              :class="item.parent_id ? 'text-gray-600' : 'text-gray-400 italic'"
            >
              {{ getParentName(item.parent_id) }}
            </span>
          </table-column>

          <!-- Actions -->
          <table-column class="text-center">
            <div class="flex justify-center gap-2">
              <!-- Edit Button -->
              <button
                @click="openEditModal(item)"
                class="px-3 py-1 text-sm text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded transition-colors"
              >
                Edit
              </button>

              <!-- Delete Button -->
              <button
                @click="confirmDelete(item)"
                class="px-3 py-1 text-sm text-red-600 hover:text-red-800 hover:bg-red-50 rounded transition-colors"
              >
                Delete
              </button>
            </div>
          </table-column>
        </template>
      </list-table>

      <!-- Pagination -->
      <the-pagination
        v-if="hasCategories"
        :current-page="pagination.current_page"
        :totalPages="pagination.last_page"
        @move-to="handlePageChange"
      />
    </div>

    <!-- Edit Modal -->
    <category-edit-modal
      :show="showEditModal"
      :category="editingCategory"
      @close="closeEditModal"
      @updated="handleCategoryUpdated"
    />

    <!-- Confirmation Dialog -->
    <confirm-dialog
      :show="messageStore.confirmDialog.show"
      :title="messageStore.confirmDialog.title"
      :message="messageStore.confirmDialog.message"
      :confirm-text="messageStore.confirmDialog.confirmText"
      :cancel-text="messageStore.confirmDialog.cancelText"
      :type="messageStore.confirmDialog.type"
      :loading="messageStore.confirmDialog.loading"
      @confirm="messageStore.confirmDialog.onConfirm"
      @cancel="messageStore.confirmDialog.onCancel"
    />
  </section>
</template>
