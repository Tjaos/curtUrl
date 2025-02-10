<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-2xl font-bold mb-4">Encurtador de Links</h2>

                    {{-- Formulário para encurtar links --}}
                    <form id="urlForm" action="{{ route('urls.create') }}" method="POST" class="mb-6">
                        @csrf
                        <div class="flex">
                            <input type="url" name="long_url" placeholder="Cole sua URL aqui..." required
                                class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-400 dark:focus:ring-blue-600">
                            <button type="submit" class="bg-blue-600 text-lime-800 px-4 rounded-r-md hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-400">
                                Encurtar
                            </button>
                        </div>
                        @error('long_url')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </form>

                    {{-- Lista de links encurtados --}}
                    <h3 class="text-xl font-semibold mt-8 mb-3">Seus Links</h3>
                    <table class="w-full border-collapse border border-gray-300 dark:border-gray-600">
                        <thead>
                            <tr class="bg-gray-200 dark:bg-gray-700">
                                <th class="p-2 border">URL Curta</th>
                                <th class="p-2 border">URL Original</th>
                                <th class="p-2 border">Cliques</th>
                                <th class="p-2 border">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($urls as $url)
                            <tr class="border dark:border-gray-600">
                                <td class="p-2 border">
                                    <a href="{{ url($url->short_url) }}" target="_blank" class="text-blue-500 underline dark:text-blue-400">
                                        {{ url($url->short_url) }}
                                    </a>
                                </td>
                                <td class="p-2 border truncate" style="max-width: 200px;">
                                    {{ $url->long_url }}
                                </td>
                                <td class="p-2 border text-center">
                                    {{ $url->access_logs_count }}
                                </td>
                                <td class="p-2 border text-center">
                                    <form action="{{ route('urls.delete', $url->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-red-900 px-2 py-1 rounded hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-500">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>