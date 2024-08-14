<script setup>
import {ref, watch} from "vue";
import debounce from "lodash/debounce.js";
import {router} from "@inertiajs/vue3";
import SearchDropDown from "@/Components/WatchList/SearchDropDown.vue";
import SearchInput from "@/Components/WatchList/SearchInput.vue";


const isStockDropDownShown = ref(true);

const fetchStocks = ref(true);
const selectedIndex = ref(-1);
const stockName = ref('');
const props  = defineProps({
    stocks: {
        type: Object,
    },
    viewport:{
      type: String,
      default: 'desktop'
    }
});


watch(stockName, function () {
    if (fetchStocks.value === false)
        fetchStocks.value = true;
    else
        findStock();
});
const findStock = debounce(() => {
    router.visit(route('watch.index'),{
        only: ['stocks'],
        data: {stock: stockName.value},
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
    if (!props.stocks) return;
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

</script>

<template>


    <div v-if="viewport === 'desktop'" class="hidden md:block relative ">
        <SearchInput
            v-model:stockName="stockName"
            @handle-key-down="handleKeyDown"
            @hide-dropdown="isStockDropDownShown = false"
            @show-dropdown="isStockDropDownShown = true"
        />
        <SearchDropDown
                @selectOption="selectOption"
                :stocks="props.stocks"
                v-model:selectedIndex="selectedIndex"
                v-model:isStockDropDownShown="isStockDropDownShown"
                />

    </div>


</template>

<style scoped>

</style>
