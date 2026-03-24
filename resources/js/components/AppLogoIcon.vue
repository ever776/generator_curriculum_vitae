<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

type Props = {
    className?: HTMLAttributes['class'];
};

defineProps<Props>();
</script>

<template>
    <svg
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 32 32"
        :class="className"
        v-bind="$attrs"
    >
        <rect x="5" y="3" width="22" height="26" rx="2" fill="currentColor" />
        <path
            d="M19 3H27V11"
            stroke="white"
            stroke-width="1.5"
            stroke-linecap="round"
            stroke-linejoin="round"
            fill="none"
        />
        <path d="M19 3L27 11H19V3Z" fill="white" fill-opacity="0.3" />
        <rect x="9" y="14" width="14" height="2" rx="1" fill="white" />
        <rect x="9" y="18" width="10" height="2" rx="1" fill="white" />
        <rect x="9" y="22" width="12" height="2" rx="1" fill="white" />
    </svg>
</template>
