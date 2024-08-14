<script setup>

import {ref, watch} from "vue";
import debounce from "lodash/debounce.js";
import {router} from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import DropDownSearch from "@/Components/WatchList/SearchDropDown.vue";

const stockName = ref('');
const fetchStocks = ref(true);
const isStockDropDownShown = ref(true);
const selectedIndex = ref(-1);

const props  = defineProps({
  stocks: {
    type: Object,
  },
  isShowSearch:{
    type: Boolean
  }
});

//input
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
const selectOption = (stock) => {
  isStockDropDownShown.value = false;
  fetchStocks.value = false;
  stockName.value = stock.symbol;
};

</script>

<template>
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
                @click.stop="isStockDropDownShown = true"
                ref="stockInputMobile"
                autocomplete="off"


            />
          <DropDownSearch
              @selectOption="selectOption"
              :stocks="props.stocks"
              v-model:selectedIndex="selectedIndex"
              v-model:isStockDropDownShown="isStockDropDownShown"
              />

        </div>
    </Transition>
</template>

