import { ref, onMounted } from 'vue';

export function useFilterLoader(store, fetchMethod, getItems, getPagination, emit, type) {
  const items = ref([]);

  const loadNext = async () => {
    const pagination = getPagination();
    const currentPage = pagination.current_page;
    if (currentPage + 1 <= pagination.last_page) {
      const res = await fetchMethod(currentPage + 1);
      if (res.success) {
        items.value = items.value.concat(getItems());
      }
    }
  };

  const addItem = (id, name) => {
    emit('addFilter', { id, name, type });
  };

  const removeItem = (id, name) => {
    emit('removeFilter', { id, name, type });
  };

  onMounted(async () => {
    const res = await fetchMethod();
    if (res.success) {
      items.value = getItems();
    }
  });

  return { items, loadNext, addItem, removeItem };
}
