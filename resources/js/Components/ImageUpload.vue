<script setup>
import { ref } from 'vue';



const emit = defineEmits(['image'])

const props = defineProps({
    listingImage: String
});
const currentImage = props.listingImage 
? `/storage/${props.listingImage}` 
: null;

const preview = ref(currentImage);
const oversizeImage = ref(false);
const showRevertBtn = ref(false);

const selectImage = (e) => {
    preview.value = URL.createObjectURL(e.target.files[0]);
    oversizeImage.value = e.target.files[0].size > 3145728;
    showRevertBtn.value = true
    emit('image', e.target.files[0] )
   
}
const revertImageChange = () => {
    showRevertBtn.value = false
    preview.value = currentImage
    oversizeImage.value = false
    emit('image', null )

}
</script>

<template>
    <div>
        <span class="block text-sm font-medium text-slate-700 dark:text-slate-300" :class="{'!text-red-500' : oversizeImage}">
            {{ oversizeImage
             ? "The selected image exceeds 3Mb"
            : "Image (Max size 3Mb)"
            }}
        </span>
        <label for="image" class="block rounded-md mt-1 bg-slate-300 h-[140px] overflow-hidden cursor-pointer border-slate-300 border relative">
            <img :src="preview ?? '/storage/images/listing/default.png'"
            class=" object-cover object-center h-full w-full"
            :class="{'!border-red-500' : oversizeImage}"
            />
            <button 
            type="button"
            v-if="showRevertBtn"
            @click.prevent="revertImageChange"
            class="absolute top-2 right-2 bg-white/75 w-8 h-8 rounded-full place-items-center text-slate-700">
            <i class="fa-solid fa-rotate-left"></i>
            </button>
        </label>

        <input @input="selectImage" type="file" name="image" id="image" hidden>
    </div>
</template>