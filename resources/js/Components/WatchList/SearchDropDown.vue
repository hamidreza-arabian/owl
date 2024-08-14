<script setup>

import {onMounted, onUnmounted, ref} from "vue";

const dropdown = ref(null);
const isStockDropDownShown = defineModel('isStockDropDownShown',{ default: true });
const emits = defineEmits(['selectOption'])
const selectedIndex = defineModel('selectedIndex');

const props = defineProps({
    stocks: {
        type: Object,
    },

});

const closeDropdown = (e) => {
    if (dropdown.value && !dropdown.value.contains(e.target)){
        isStockDropDownShown.value = false;
    }
};
onMounted(() => {
    document.addEventListener('click',closeDropdown);
});
onUnmounted(() => {
    document.removeEventListener('click',closeDropdown);
});
</script>

<template>

        <div v-if="isStockDropDownShown" ref="dropdown" class="absolute w-full mt-1">
            <ul role="list" class="divide-y divide-gray-100 bg-white max-h-96 overflow-auto  shadow-lg   rounded">
                <li  v-for="(stock, index) in props.stocks"
                     :key="index"
                     :class="{ 'bg-sky-500': index === selectedIndex }"
                     @click="$emit('selectOption', stock)"
                     @mouseover="selectedIndex = index"
                     class="flex pr-3 justify-between gap-x-6 py-5 transition-all duration-200	">
                    <div class="flex min-w-0 gap-x-4">
                        <img class="h-12 w-12 flex-none rounded-full bg-gray-50" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                        <div class="min-w-0 flex-auto">
                            <p class="text-sm font-semibold leading-6 text-gray-900">{{stock.symbol}}</p>
                            <p class="mt-1 truncate text-xs leading-5 text-gray-500">{{stock.company}}</p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
</template>

<style scoped>

</style>
