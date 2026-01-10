import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useLoadingStore = defineStore('loader', () => {
  const isLoading = ref(false);

  function setLoading(status=true) {
    isLoading.value = status;
  }

  return {
    isLoading,
    setLoading,
  }
})
