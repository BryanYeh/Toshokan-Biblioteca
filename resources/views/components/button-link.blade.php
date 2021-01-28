<div class="flex justify-end pb-4">
    <a {{ $attributes->merge(['class' => 'bg-gray-800 hover:bg-gray-700 py-2 px-4 text-white rounded-md flex focus:outline-none focus:ring-2 focus:ring-gray-600 focus:ring-opacity-50']) }}>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-5 pr-2">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
        </svg>
        {{ $slot }}
    </a>
</div>
