<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from '@inertiajs/vue3';
import {ref} from "vue";
import TheMobileSearchButton from "@/Components/WatchList/TheMobileSearchButton.vue";
import TheEmptyWatchList from "@/Components/WatchList/TheEmptyWatchList.vue";
import MainContentContainer from "@/Components/Dashboard/MainContentContainer.vue";
import DesktopSearch from "@/Components/WatchList/DesktopSearch.vue";
import MobileSearch from "@/Components/WatchList/MobileSearch.vue";


const isShowSearch = ref(false);

const props = defineProps({
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
        <template #header>
            <div class=" flex justify-between  md:justify-start items-center gap-x-8">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">دیده بان</h2>

                <DesktopSearch  :stocks="stocks" />
                <TheMobileSearchButton
                    @toggle="isShowSearch = !isShowSearch"
                />
            </div>
        </template>
        <template #hidden_search>
        <MobileSearch :isShowSearch="isShowSearch" :stocks="stocks" />
        </template>
        <MainContentContainer>
            <TheEmptyWatchList v-if="watchList.length === 0" />
        </MainContentContainer>
    </authenticated-layout>
</template>


