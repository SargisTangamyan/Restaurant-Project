<script setup>

// VUE
import {ref, reactive} from 'vue'

// COMPONENTS
import ProfileBox from "@/components/profile/ProfileBox.vue";
import PriceInput from "@/components/ui/form/PriceInput.vue";
import NameInput from "@/components/ui/form/NameInput.vue";
import CategorySearch from "@/components/profile/category/CategorySearch.vue";
import IngredientSearch from "@/components/profile/ingredient/IngredientSearch.vue";
import ChosenItems from "@/components/ui/ChosenItems.vue";
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

const ingredientRef = ref(null);
const ingredients = reactive({});

const description = ref('');
const image = ref(null);

// METHODS
const chooseCategory = (id) => {
  category.value = id;
}

const chooseIngredient = (id, name) => {
  if (!ingredients[id]) {
    ingredients[id] = name;
  }

  ingredientRef.value.clearQuery();
}

const removeIngredient = (id) => {
  delete ingredients[id];
}

const handleFileUpload = (file) => {
  image.value = file
}

const addDish = async function () {
  const res = await dishStore.addDish({
    name: name.value,
    price: price.value,
    description: description.value,
    category_id: category.value,
    image: image.value,
  });
  if (res.success) {
    messageStore.showMessage(res.message, 'success');
  } else {
    messageStore.showMessage(res.message, 'error');
    console.log(res.errors)
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
          <category-search @word-chosen="chooseCategory"/>
        </div>

        <!-- INGREDIENTS -->
        <div>
          <ingredient-search @word-chosen="chooseIngredient" ref="ingredientRef"/>
          <chosen-items :items="ingredients" @remove-item="removeIngredient"/>
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
