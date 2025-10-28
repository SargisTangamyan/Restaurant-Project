
<script setup>

// VUE
import {ref, reactive} from 'vue'

// COMPONENTS
import ProfileBox from "@/components/profile/ProfileBox.vue";
import PriceInput from "@/components/ui/form/PriceInput.vue";
import NameInput from "@/components/ui/form/NameInput.vue";
import CategorySearch from "@/components/profile/category/CategorySearch.vue";
import IngredientSearch from "@/components/profile/ingredient/IngredientSearch.vue";
import ImageInput from "@/components/ui/form/ImageInput.vue";
import FormLabel from "@/components/ui/form/FormLabel.vue";

// STORE
import { useDishStore } from "@/stores/index.js";
const dishStore = useDishStore();

import { useMessageStore } from "@/stores/index.js";
const messageStore = useMessageStore();

// REF
const name = ref('');
const price = ref(0);
const category = ref(null);
const categoryRef = ref(null);

const ingredientRef = ref(null);
const ingredients = reactive({});
const ingredientQuantities = reactive({});

const description = ref('');
const image = ref(null);

// METHODS
const chooseCategory = (id) => {
  category.value = id;
}

const chooseIngredient = (id, name, unit) => {
  if (!id || !name) return;

  if (!ingredients[id]) {
    ingredients[id] = {name, unit};
    ingredientQuantities[id] = 1; // Default quantity
  }

  ingredientRef.value.clearQuery();
}

const removeIngredient = (id) => {
  delete ingredients[id];
  delete ingredientQuantities[id];
}

const updateIngredientQuantity = (id, quantity) => {
  if (quantity > 0) {
    ingredientQuantities[id] = quantity;
  }
}

const handleFileUpload = (file) => {
  image.value = file
}

const clearFields = function() {
  name.value = '';
  price.value = 0;
  category.value = null;
  description.value = '';
  image.value = null;
  Object.keys(ingredients).forEach(id => delete ingredients[id]);
  Object.keys(ingredientQuantities).forEach(id => delete ingredientQuantities[id]);
  categoryRef.value.clearQuery();

  // Clear ingredient search input
  if (ingredientRef.value) {
    ingredientRef.value.clearQuery();
  }
}

const addDish = async function () {
  // Format ingredients with quantities
  const ingredientsArray = Object.keys(ingredients).map(id => ({
    id: parseInt(id),
    quantity: ingredientQuantities[id] || 1
  }));

  const res = await dishStore.addDish({
    name: name.value,
    price: price.value,
    description: description.value,
    category_id: category.value,
    image: image.value,
    ingredients: ingredientsArray
  });
  if (res.success) {
    clearFields();
    messageStore.showMessage(res.message, 'success');
  } else {
    messageStore.showMessage(res.message, 'error');
  }
}

</script>

<template>
  <profile-box heading="Add Product">

    <form @submit.prevent="addDish" class="space-y-5">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- NAME -->
        <div>
          <name-input v-model="name" label="Name" placeholder="e.g. Burger"/>
        </div>

        <!-- PRICE -->
        <div>
          <price-input v-model="price" :mb="false"/>
        </div>

        <!-- CATEGORY -->
        <div>
          <category-search @word-chosen="chooseCategory" ref="categoryRef"/>
        </div>

        <!-- INGREDIENTS -->
        <div class="relative">
          <ingredient-search @word-chosen="chooseIngredient" ref="ingredientRef"/>
          <div v-if="Object.keys(ingredients).length > 0" class="mt-3 space-y-2 absolute w-full">
            <div
              v-for="(ingredient, id) in ingredients"
              :key="id"
              class="flex items-center gap-3 bg-gray-50 p-3 rounded-lg border border-gray-200"
            >
              <span class="flex-1 text-gray-700 font-medium">{{ ingredient.name }}</span>
              <div class="flex items-center gap-2">
                <label class="text-sm text-gray-600">Qty:</label>
                <input
                  type="number"
                  min="0.01"
                  step="0.01"
                  :value="ingredientQuantities[id]"
                  @input="updateIngredientQuantity(id, parseFloat($event.target.value))"
                  class="w-20 px-2 py-1 border border-gray-300 rounded focus:ring-2 focus:ring-primary/40 focus:border-primary text-center"
                />
                <span class="text-sm text-gray-600">{{ ingredient.unit }}</span>
              </div>
              <button
                type="button"
                @click="removeIngredient(id)"
                class="text-red-500 hover:text-red-700 px-2"
              >
                ✕
              </button>
            </div>
          </div>
        </div>

        <!-- DESCRIPTION -->
        <div class="col-start-1">
          <form-label label="Description"/>
          <textarea
            rows="3"
            placeholder="Enter product description"
            class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-primary/40 focus:border-primary text-gray-800 placeholder-gray-400 resize-none"
            v-model="description"
          ></textarea>
        </div>

        <!-- IMAGE -->
        <div class="col-start-1">
          <image-input @file-selected="handleFileUpload"/>
        </div>

      </div>
      <!-- SUBMIT BUTTON -->
      <div class="flex justify-start">
        <button
          type="submit"
          class="button-cgreen"
        >
          Add Product
        </button>
      </div>
    </form>

  </profile-box>
</template>

<style scoped>

</style>
