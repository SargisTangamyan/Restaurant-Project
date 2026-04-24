<script setup>
import { ref, onMounted } from 'vue';
import { sender } from '@/api/Sender.js';
import { INGREDIENT_ALL, ALLERGIES, ALLERGY_ADD, ALLERGY_REMOVE } from '@/constants/urls.js';

const allAllergicIngredients = ref([]);
const userAllergyIds = ref(new Set());
const saving = ref(null);
const loading = ref(true);

onMounted(async () => {
  const [allRes, userRes] = await Promise.all([
    sender.sendRequest('GET', `${INGREDIENT_ALL}?per_page=100`),
    sender.sendRequest('GET', ALLERGIES),
  ]);

  if (allRes.success) {
    allAllergicIngredients.value = allRes.data.data.filter(i => i.is_allergic);
  }

  if (userRes.success) {
    userAllergyIds.value = new Set(userRes.data.allergies.map(i => i.id));
  }

  loading.value = false;
});

const isSelected = (id) => userAllergyIds.value.has(id);

const toggle = async (ingredient) => {
  if (saving.value !== null) return;
  saving.value = ingredient.id;

  if (isSelected(ingredient.id)) {
    const res = await sender.sendRequest('DELETE', ALLERGY_REMOVE(ingredient.id));
    if (res.success) userAllergyIds.value.delete(ingredient.id);
  } else {
    const res = await sender.sendRequest('POST', ALLERGY_ADD(ingredient.id));
    if (res.success) userAllergyIds.value.add(ingredient.id);
  }

  userAllergyIds.value = new Set(userAllergyIds.value);
  saving.value = null;
};
</script>

<template>
  <section class="bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-semibold mb-1">Health & Safety</h2>
    <p class="text-sm text-gray-500 mb-6">Select the ingredients you are allergic to.</p>

    <div v-if="loading" class="text-sm text-gray-400">Loading ingredients...</div>

    <div v-else-if="allAllergicIngredients.length === 0" class="text-sm text-gray-400">
      No allergic ingredients available.
    </div>

    <div v-else class="flex flex-wrap gap-2">
      <button
        v-for="ingredient in allAllergicIngredients"
        :key="ingredient.id"
        @click="toggle(ingredient)"
        :disabled="saving === ingredient.id"
        class="px-3 py-1.5 rounded-full border text-sm font-medium transition"
        :class="isSelected(ingredient.id)
          ? 'bg-red-100 border-red-400 text-red-700'
          : 'bg-gray-100 border-gray-300 text-gray-600 hover:bg-gray-200'"
      >
        <span v-if="saving === ingredient.id" class="opacity-50">...</span>
        <template v-else>
          <span v-if="isSelected(ingredient.id)">✕ </span>{{ ingredient.name }}
        </template>
      </button>
    </div>
  </section>
</template>

<style scoped>
</style>
