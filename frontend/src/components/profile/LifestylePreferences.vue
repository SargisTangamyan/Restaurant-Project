<script setup>
import { ref } from 'vue'
import NameInput from "@/components/ui/form/NameInput.vue";

const dietStyles = [
  { label: 'Vegetarian', icon: '🥦' },
  { label: 'Vegan', icon: '🌱' },
  { label: 'Keto', icon: '🥑' },
  { label: 'Halal', icon: '🕌' },
]

const foodLikes = ref(new Set())
const selectedDiet = ref('Keto')
const currentLikeFood = ref('')

// METHODS
const addFood = function ()
{
  const food = currentLikeFood.value;
  if (food === '') return;
  foodLikes.value.add(food.toLowerCase());
  currentLikeFood.value = '';
}

const selectDiet = (label) => {
  selectedDiet.value = label
}
</script>

<template>
  <section class="bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-semibold mb-4">Lifestyle & Diet</h2>

    <!-- Diet style header -->
    <div class="flex items-center justify-between mb-4">
      <div>
        <p class="text-sm font-medium text-gray-700">Diet style</p>
        <p class="text-xs text-gray-500">
          Choose the diet that best fits you.
        </p>
      </div>

      <label class="flex items-center gap-2 text-sm text-gray-600">
        <input type="checkbox" class="rounded border-gray-300" />
        No diet style
      </label>
    </div>

    <!-- Diet options -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
      <button
        v-for="diet in dietStyles"
        :key="diet.label"
        @click="selectDiet(diet.label)"
        class="flex flex-col items-center gap-2 px-3 py-3 border rounded-lg text-sm transition"
        :class="diet.label === selectedDiet
          ? 'border-cgreen bg-blue-50 text-green-700'
          : 'border-gray-300 text-gray-700 hover:bg-gray-50'"
      >
        <span class="text-xl">{{ diet.icon }}</span>
        <span>{{ diet.label }}</span>
      </button>
    </div>

    <!-- Diet details (simple, informational) -->
    <div class="mb-6 space-y-2 border-1 px-4 py-2 border-cgreen rounded-lg">
      <p class="text-sm text-gray-700">
        <span class="font-medium text-cgreen">Eat:</span>
        eggs, avocados, meats, cheese
      </p>
      <p class="text-sm text-gray-700">
        <span class="font-medium text-red-600">Avoid:</span>
        bread, rice, sugar
      </p>
    </div>

    <!-- Food likes -->
    <div class="mb-6">
      <div class="flex flex-column gap-4 items-end mb-4">
        <name-input label="Food You Like" :mb="false" v-model="currentLikeFood" class="w-75"/>
        <button class="button-cgreen mt-0 h-[42px]" @click="addFood">Add</button>
      </div>

      <div class="flex flex-wrap gap-2">
        <span
          v-for="tag in foodLikes"
          :key="tag"
          class="px-3 py-1 text-sm border rounded-full border-gray-300 text-gray-700'"
        >
          {{ tag }}
        </span>
      </div>
    </div>

    <!-- Actions -->
    <div class="flex justify-between">
      <button class="button-cgreen">
        Save Changes
      </button>
    </div>
  </section>
</template>
