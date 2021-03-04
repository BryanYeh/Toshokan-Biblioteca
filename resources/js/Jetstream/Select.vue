<template>
    <select v-model="selected" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
        <option v-for="option in options" v-bind:value="option.id">
            {{ option.name }}
        </option>
    </select>
</template>

<script>
export default {
    props: {
        options: {
            type: Object,
            required: true
        },
        default: {
            type: String,
            required: false,
            default: null
        },
        tabindex: {
            type: Number,
            required: false,
            default: 0
        }
    },
    data() {
        return {
            selected: this.default ? this.default : this.options.length > 0 ? this.options[0] : null
        };
    }
};
</script>
