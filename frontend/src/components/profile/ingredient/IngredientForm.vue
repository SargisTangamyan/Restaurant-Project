<script setup>
// COMPONENTS
import FormInput from "@/components/ui/form/FormInput.vue";
import FormBox from "@/components/ui/form/FormBox.vue";

// VUE
import { ref, watch } from 'vue';

// STORE
import { useIngredientStore } from '@/stores/index.js'

const ingredientStore = useIngredientStore();

const iName = ref('');
const unit = ref('');
const price = ref(0);

watch(price, (newValue) => {
  console.log(newValue);
  if (newValue < 0 || newValue === null || newValue === undefined || newValue === '') {
    price.value = 0;
  }
})

const nameErrors = ref([]);
const unitErrors = ref([]);
const priceErrors = ref([]);

const clearForm = function () {
  iName.value = '';
  unit.value = '';
  price.value = 0;
}

const showErrors = function (errors) {
  if (errors.name) {
    nameErrors.value = errors.name;
  }
  if (errors.price) {
    priceErrors.value = errors.price;
  }

  if (errors.unit) {
    unitErrors.value = errors.unit;
  }
}

const validate = function () {
  const errors = {};
  if (iName.value.length === 0) {
    errors.name = ['Name cannot be empty'];
  }
  if (unit.value.length === 0) {
    errors.unit = ['Unit cannot be empty'];
  }
  if (price.value < 0) {
    errors.price = ['Price cannot be negative'];
  }

  if (errors.name || errors.price || errors.unit) {
    showErrors(errors);
    return false;
  }
  return true;
}

const addIngredient = async function() {
  if (!validate()) return;
  const res = await ingredientStore.addIngredient({'name': iName.value, 'unit': unit.value, 'price': price.value});
  if (res.success) {
    clearForm();
    console.log('success');
  } else {
    showErrors(res.errors);
  }
}
</script>

<template>
  <form-box @form-submit="addIngredient" button-text="Add Ingredient" heading="Add Ingredient">
    <template #inputs>
      <div>
        <form-input v-model="iName" placeholder="e.g. Apple" input-type="text" label="Ingredient Name" :errors="nameErrors" />

        <form-input v-model="unit" placeholder="e.g. Kg" input-type="text" label="Unit" :errors="unitErrors" />

        <form-input v-model="price" input-type="number" label="Price" :errors="priceErrors" />
      </div>


    </template>
  </form-box>
</template>

<style scoped>

</style>
