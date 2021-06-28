<template>
    <app-link
        v-bind="$attrs"
        class="hover:bg-gray-100 hover:text-blue-600 p-4 w-full flex"
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
