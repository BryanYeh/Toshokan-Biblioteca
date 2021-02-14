<template>
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
        <div class="flex-1 flex items-center justify-between">
            <div>
                <span class="relative z-0 inline-flex rounded-lg">
                    <span v-for="(link,index) in obj.links">
                        <!-- Three Dots Seperator -->
                        <span aria-disabled="true" v-if="typeof link == 'string'">
                            <span class="relative inline-flex items-center px-4 py-2 ml-px text-sm font-medium text-gray-700 bg-white cursor-default leading-5">{{ link }}</span>
                        </span>
                        <span v-else>
                            <span aria-current="index" v-if="index + 1 == link.current_page">
                                <span class="relative inline-flex items-center px-4 py-2 ml-px text-sm font-medium cursor-default leading-5 bg-gray-800 text-white rounded-lg">{{ page }}</span>
                            </span>
                            <a v-else-if="link.url !== null && stringContains(link.label,'Next')" :href="link.url" class="relative inline-flex items-center px-4 py-2 ml-px text-sm font-medium text-gray-800 bg-white leading-5 rounded-lg border border-transparent hover:border-gray-700 hover:text-gray-600 focus:z-10 focus:outline-none focus:ring-2 ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a v-else-if="link.url !== null && stringContains(link.label,'Previous')" :href="link.url" class="relative inline-flex items-center px-4 py-2 ml-px text-sm font-medium text-gray-800 bg-white leading-5 rounded-lg border border-transparent hover:border-gray-700 hover:text-gray-600 focus:z-10 focus:outline-none focus:ring-2 ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a v-else-if="link.url !== null" :href="link.url" class="relative inline-flex items-center px-4 py-2 ml-px text-sm font-medium text-gray-800 bg-white leading-5 rounded-lg border border-transparent hover:border-gray-700 hover:text-gray-600 focus:z-10 focus:outline-none focus:ring-2 ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                                {{ link.label }}
                            </a>
                        </span>
                    </span>
                </span>
            </div>
        </div>
    </nav>

</template>

<script>
    export default {
        props: ['obj'],
        methods: {
            stringContains(str,text){
                return (typeof str == 'string' && str.indexOf(text) > -1);
            }
        }
    }
</script>



