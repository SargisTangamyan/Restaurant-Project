<script setup>
import { ref } from 'vue';
import RatingStars from "@/components/ui/RatingStars.vue";
import {STORAGE} from '@/constants/urls.js'
import {faPencil, faTrash} from "@fortawesome/free-solid-svg-icons";

const props = defineProps({
  review: {
    type: Object,
    required: true,
  },
  currentUserId: {
    type: Number,
    default: null,
  },
  dishId: {
    type: Number,
    required: true,
  },
});

console.log(props.review);

const emit = defineEmits(['updated', 'deleted']);

const isEditing = ref(false);
const editRating = ref(props.review.rating);
const editComment = ref(props.review.comment ?? '');
const isSaving = ref(false);

const isOwn = () => props.currentUserId && props.currentUserId === props.review.user_id;

const editHoveredRating = ref(0);

const getEditStarFill = (i) => {
  const rating = editHoveredRating.value || editRating.value;
  if (rating >= i) return '100%';
  if (rating >= i - 0.5) return '50%';
  return '0%';
};

const startEdit = () => {
  editRating.value = props.review.rating;
  editComment.value = props.review.comment ?? '';
  isEditing.value = true;
};

const cancelEdit = () => {
  isEditing.value = false;
};

const submitEdit = async () => {
  if (editRating.value < 0.5 || editRating.value > 5) return;
  isSaving.value = true;
  emit('updated', { reviewId: props.review.id, rating: editRating.value, comment: editComment.value });
  isSaving.value = false;
  isEditing.value = false;
};

const confirmDelete = () => {
  emit('deleted', props.review.id);
};
</script>

<template>
  <div class="border-b border-gray-100 pb-4">
    <!-- View mode -->
    <template v-if="!isEditing">
      <div class="flex items-center justify-between mb-2">
        <div class="flex items-center gap-2">
          <img
            :src="review.user_image ? STORAGE + review.user_image : '/src/assets/images/profile/no-avatar.jpg'"
            alt="user"
            class="w-10 h-10 rounded-full object-cover"
          >
          <div>
            <h6 class="font-semibold text-gray-800">{{ review.user_name }}</h6>
            <span class="text-sm text-gray-500">{{ review.created_at }}</span>
          </div>
        </div>
        <div class="flex items-center gap-3">
          <rating-stars :stars="review.rating" />
          <div v-if="isOwn()" class="flex gap-2 text-sm">
            <button @click="startEdit" class="text-blue-500 hover:text-blue-700 transition">
              <font-awesome-icon :icon="faPencil" />
            </button>
            <button @click="confirmDelete" class="text-red-400 hover:text-red-600 transition">
              <font-awesome-icon :icon="faTrash" />
            </button>
          </div>
        </div>
      </div>
      <p class="text-gray-600 text-sm leading-relaxed">{{ review.comment }}</p>
    </template>

    <!-- Edit mode -->
    <template v-else>
      <div class="space-y-3">
        <div class="flex items-center gap-1" @mouseleave="editHoveredRating = 0">
          <div
            v-for="i in 5"
            :key="i"
            class="relative text-xl w-6 h-6 cursor-pointer select-none"
          >
            <font-awesome-icon :icon="['fas', 'star']" class="text-gray-300 w-6 h-6" />
            <div class="absolute inset-0 overflow-hidden" :style="{ width: getEditStarFill(i) }">
              <font-awesome-icon :icon="['fas', 'star']" class="text-yellow-400 absolute left-0 top-0 w-6 h-6" />
            </div>
            <div class="absolute inset-y-0 left-0 w-1/2" @mouseenter="editHoveredRating = i - 0.5" @click="editRating = i - 0.5" />
            <div class="absolute inset-y-0 right-0 w-1/2" @mouseenter="editHoveredRating = i" @click="editRating = i" />
          </div>
          <span class="ml-2 text-sm text-gray-500">{{ editHoveredRating || editRating }}/5</span>
        </div>
        <textarea
          v-model="editComment"
          rows="3"
          class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-2 focus:ring-cgreen focus:outline-none"
        />
        <div class="flex gap-2">
          <button
            @click="submitEdit"
            :disabled="isSaving"
            class="bg-cgreen hover:bg-emerald-700 text-white text-sm font-medium rounded-lg px-4 py-2 transition"
          >
            Save
          </button>
          <button @click="cancelEdit" class="text-sm text-gray-500 hover:text-gray-700 px-4 py-2">
            Cancel
          </button>
        </div>
      </div>
    </template>
  </div>
</template>
