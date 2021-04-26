<template>
    <div class="relative" ref="dropdownMenu">
        <div @click="visible = !visible" class="flex cursor-pointer">
            <slot name="dropdown_head"></slot>
        </div>
        <div v-if="visible" :class="classes">
            <slot name="dropdown_body"></slot>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        right: {
            type: String,
            default: '',
        },
        top: {
            type: String,
            default: 'top-16'
        },
        width: {
            type: String,
            default: 'w-56'
        }
    },
    data() {
        return {
            visible: false,
        };
    },
    computed: {
        classes() {
            return [
                "absolute bg-white flex-col rounded-md shadow-md border border-gray-200 py-1",
                this.right, this.top, this.width
            ];
        },
    },
    methods: {
        documentClick(e) {
            let el = this.$refs.dropdownMenu;
            let target = e.target;
            if (el !== target && !el.contains(target)) {
                this.visible = false;
            }
        },
    },
    created() {
        document.addEventListener("click", this.documentClick);
    },
    unmounted() {
        // important to clean up!!
        document.removeEventListener("click", this.documentClick);
    },
};
</script>
