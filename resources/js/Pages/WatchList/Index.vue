<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {ref, watch} from "vue";
import Modal from "@/Components/Modal.vue";
import TextInput from "@/Components/TextInput.vue";
import debounce from "lodash/debounce";
import {Head, router} from '@inertiajs/vue3';


const addStockModalIsShow = ref(false);
const stockName = ref('');
watch(stockName, function () {
    findStock();
});
const findStock = debounce(() => {
    router.get(route('watch.index'), {search: stockName.value}, {
        preserveState: true,
        preserveScroll: true
    });
}, 500);
defineProps({
    stocks: {
        type: Object,
    },
    watchList: {
        type: Object,
    }
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
        <template #header><h1>دیده بان</h1></template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <template v-if="!watchList">
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
                            <div class="mt-6">
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
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
        <Modal
            :show="addStockModalIsShow"
            position="middle"
            @close="addStockModalIsShow = false">
            <div class="p-6">
                <div class="mt-6 flex justify-center flex-col items-center ">
                    <TextInput
                        id="stock"
                        ref="stockNameInput"
                        v-model="stockName"
                        class="mt-1 block w-3/4"
                        placeholder="جست و جو در سهام"
                        type="text"

                    />

                </div>
            </div>
        </Modal>
    </authenticated-layout>
</template>


