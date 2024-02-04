<template>
    <div :class="['flex h-full my-6', isMyMsg && 'justify-end']">
        <span v-if="!isMyMsg" class="text-sm pr-2 border-r-2 border-cyan-600">{{
            message.id
        }}</span>
        <div class="flex flex-col ml-3">
            <span class="text-sm text-red-400">{{ message.user.name }}</span>
            <p class="text-lg">{{ message.body }}</p>
            <span class="ml-auto text-sm">{{ message.createdAt }}</span>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { Message as MessageType } from "@/message.type";
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";

interface MessageProps {
    message: MessageType;
}

const props = defineProps<MessageProps>();
const $page = usePage();

const isMyMsg = computed(
    () => $page.props.auth.user.id === props.message.user.id
);
console.log(usePage().props);
</script>
