<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800 leading-tight">
            My ToDo List
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 space-y-8">

            {{-- Notifikasi Flash --}}
            @if (session('success'))
                <div class="p-4 bg-green-100 border border-green-300 text-green-800 rounded shadow">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="p-4 bg-red-100 border border-red-300 text-red-800 rounded shadow">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Form Tambah ToDo --}}
            <div class="bg-white shadow rounded-lg p-6">
                <form method="POST" action="{{ route('todos.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Judul</label>
                        <input type="text" name="title" required
                            class="mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="description" rows="2"
                            class="mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200"></textarea>
                    </div>
                    <div class="text-right">
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded-md shadow hover:bg-blue-700 transition duration-150">
                            ➕ Tambah ToDo
                        </button>
                    </div>
                </form>
            </div>

            {{-- Daftar ToDo --}}
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Daftar ToDo</h3>
                <ul class="space-y-4">
                    @forelse ($todos as $todo)
                        <li class="border px-4 py-3 rounded-md bg-gray-50 flex items-center justify-between">
                            <form method="POST" action="{{ route('todos.update', $todo->id) }}" class="flex items-center gap-3 flex-1">
                                @csrf @method('PUT')
                                <input type="checkbox" name="is_done" value="1" onchange="this.form.submit()" {{ $todo->is_done ? 'checked' : '' }}
                                    class="h-5 w-5 text-green-600 rounded border-gray-300">
                                <div class="flex flex-col w-full">
                                    <input type="text" name="title" value="{{ $todo->title }}"
                                        class="font-medium bg-transparent border-0 focus:ring-0" />
                                    <input type="text" name="description" value="{{ $todo->description }}"
                                        class="text-sm text-gray-500 bg-transparent border-0 focus:ring-0" />
                                </div>
                                <button type="submit"
                                    class="bg-green-600 text-white px-3 py-1.5 rounded-md text-sm shadow hover:bg-green-700 transition">
                                    💾
                                </button>
                            </form>

                            <form method="POST" action="{{ route('todos.destroy', $todo->id) }}">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="bg-red-600 text-white px-3 py-1.5 rounded-md text-sm shadow hover:bg-red-700 transition">
                                    🗑️
                                </button>
                            </form>
                        </li>
                    @empty
                        <li class="text-gray-500">Belum ada to-do.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
