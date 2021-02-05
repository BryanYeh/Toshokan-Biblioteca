<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Books') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-button-link :href="route('book.create')">
                Add book
            </x-button-link>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="table w-full text-center">
                        <tr>
                            <th>Image</th>
                            <th>Title</th>
                            <th>ISBN</th>
                            <th>Author</th>
                            <th>Actions</th>
                        </tr>
                        @foreach ($books as $book)
                        <tr>
                            <td class="py-2">{{ $book->image }}</td>
                            <td class="py-2">{{ $book->title }}</td>
                            <td class="py-2">{{ $book->isbn }}</td>
                            <td class="py-2">{{ $book->author }}</td>
                            <td class="py-2">
                                <a href="{{ route('book.edit',['id' => $book->id ]) }}" class="inline-block">
                                    <svg class="h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if ($books->links()->paginator->hasPages())
        <div class="pb-12">
            <div class="lg:px-8 max-w-min mx-auto sm:px-6">
                <div class="bg-white px-6 py-4 shadow-lg rounded-lg">
                    {{ $books->onEachSide(3)->links() }}
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
