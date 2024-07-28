<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {onMounted, onUnmounted, ref, watch} from "vue";
import Modal from "@/Components/Modal.vue";
import TextInput from "@/Components/TextInput.vue";
import debounce from "lodash/debounce";
import {Head, router} from '@inertiajs/vue3';

const isStockDropDownShown = ref(true);
const addStockModalIsShow = ref(false);
const stockName = ref('');
const isShowSearch = ref(false);
const selectedIndex = ref(-1);
const fetchStocks = ref(true);
watch(stockName, function () {
    if (fetchStocks.value === false)
        fetchStocks.value = true;
    else
        findStock();
});
const findStock = debounce(() => {
    router.get(route('watch.index'), {stock: stockName.value}, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: (page) => {
            isStockDropDownShown.value = true;
        }
    });
}, 300);
const selectOption = (stock) => {
    isStockDropDownShown.value = false;
    fetchStocks.value = false;
    stockName.value = stock.symbol;
};
const handleKeyDown = (event) => {
    if (event.key === 'ArrowDown') {
        selectedIndex.value = (selectedIndex.value + 1) % props.stocks.length;
    } else if (event.key === 'ArrowUp') {
        selectedIndex.value = (selectedIndex.value - 1 + props.stocks.length) % props.stocks.length;
    } else if (event.key === 'Enter' && selectedIndex.value >= 0) {
        selectOption(props.stocks[selectedIndex.value]);
    } else if (event.key === 'Escape') {
        isStockDropDownShown.value = false;
    }
};
const dropdown = ref(null);
const stockInput = ref(null);
const stockInputMobile = ref(null);
const closeDropdown = (e) => {
    if (dropdown.value && !dropdown.value.contains(e.target) && stockInput.value && !stockInput.value.$el.contains(e.target) && stockInputMobile.value && !stockInputMobile.value.$el.contains(e.target)){
        isStockDropDownShown.value = false;
    }
};
const props = defineProps({
    stocks: {
        type: Object,
    },
    watchList: {
        type: Object,
    }
});
onMounted(() => {
    document.addEventListener('click',closeDropdown);
});
onUnmounted(() => {
    document.removeEventListener('click',closeDropdown);
});


</script>

<template>
    <Head>
        <title>سهام های تحت نظر</title>
        <meta
            content="لیست سهام های تحت نظر و اضافه کردن سهام برای زیرنطر گرفتن و مطلع شدن از قیمت های مد نظر مانند مقاومت، حمایت، اهداف و ... "
            name="description">
    </Head>

    <authenticated-layout>
        <template #header>
            <div class=" flex justify-between  md:justify-start items-center gap-x-8">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">دیده بان</h2>
                <div class="hidden md:block relative ">
                    <text-input v-model="stockName"
                                placeholder="جست و جو در سهام..."
                                type="text"
                                @keydown="handleKeyDown"
                                class="placeholder:italic placeholder:text-slate-400 min-w-80  placeholder:text-sm "
                                @click="isStockDropDownShown = true"
                                ref="stockInput"
                    />

                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                        <svg @click="isShowSearch = !isShowSearch" class="w-6 h-6 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                    </div>
                    <div v-if="isStockDropDownShown" ref="dropdown" class="absolute w-full mt-1">
                        <ul role="list" class="divide-y divide-gray-100 bg-white max-h-70 overflow-auto  shadow-lg   rounded">
                                <li  v-for="(stock, index) in stocks"
                                     :key="index"
                                     :class="{ 'bg-sky-500': index === selectedIndex }"
                                     @mouseover="selectedIndex = index"
                                     @click="selectOption(stock)"
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
                </div>
                <div class="flex md:hidden items-center flex-row-reverse">
                    <svg @click="isShowSearch = !isShowSearch" class="w-6 h-6 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                </div>
            </div>
        </template>
        <template #hidden_search>
            <Transition
                enter-active-class="ease-out duration-700"
                enter-from-class="-translate-y-8"
                enter-to-class="translate-y-0"
                leave-active-class="ease-in duration-500"
                leave-from-class="translate-y-0"
                leave-to-class="-translate-y-8">
                <div class="relative" v-show="isShowSearch">
                    <TextInput
                        id="stock"
                        v-model="stockName"
                        class="border-t-0 rounded-none w-full h-14 placeholder:italic placeholder:text-slate-400 px-4"
                        placeholder="جست و جو در سهام..."
                        type="text"
                        @keydown="handleKeyDown"
                        @click="isStockDropDownShown = true"
                        ref="stockInputMobile"


                    />
                    <div v-if="isStockDropDownShown">
                        <ul   role="list" class="divide-y divide-gray-100 bg-white max-h-70 overflow-auto  pr-3 rounded">
                            <li  v-for="(stock, index) in stocks"
                                 :key="index"
                                 :class="{ 'bg-sky-500': index === selectedIndex }"
                                 @mouseover="selectedIndex = index"
                                 @click="selectOption(stock)"
                                class="flex justify-between gap-x-6 py-5">
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
                </div>
            </Transition>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <template v-if="watchList.length === 0">
                        <div class="text-center">
                            <svg aria-hidden="true" class="w-12 mx-auto text-slate-400 h-12" fill="none"
                                 stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    vector-effect="non-scaling-stroke"></path>
                            </svg>
                            <h3 class="text-gray-900 mt-2 font-semibold text-sm">بدون نماد</h3>
                            <p class="text-sm text-gray-500">با افزودن نمادی شروع کنید.</p>
                            <!--                            <div class="mt-6">
                                                            <button
                                                                class="shadow-none text-white text-sm font-semibold
                                                                    py-2 px-3 bg-indigo-600 hover:bg-indigo-500 rounded-md items-center inline-flex"
                                                                type="button"
                                                                @click="addStockModalIsShow = !addStockModalIsShow">
                                                                <svg aria-hidden="true" class="w-5 h-5 ml-1.5 -mr-0.5" fill="currentColor"
                                                                     viewBox="0 0 20 20"
                                                                     xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z"></path>
                                                                </svg>
                                                                افزودن سهام
                                                            </button>
                                                        </div>-->
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </authenticated-layout>
</template>


