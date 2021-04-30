<template>
    <app-link
        v-bind="$attrs"
        class="hover:bg-gray-100 hover:text-blue-600 px-4 py-2 rounded-md cursor-pointer"
    >
        <slot />
    </app-link>
</template>

<script>
import AppLink from "./AppLink";

export default {
    components: { AppLink },
};
</script>
