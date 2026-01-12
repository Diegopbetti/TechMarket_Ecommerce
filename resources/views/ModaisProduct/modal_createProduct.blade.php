<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div id="create" class="fixed inset-0 items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-lg w-[400px] sm:w-1/3 shadow-lg">
            <h2 class="text-xl font-bold mb-4">Criar Produto</h2>
            <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="photo" placeholder="Photo" class="border p-2 w-full mb-2 rounded" required>
                <input type="text" name="name" placeholder="Name" class="border p-2 w-full mb-2 rounded" required>
                <div class="flex">
                    <input type="text" name="category" placeholder="Category" class="border p-2 w-1/2 mb-2 rounded" required>
                    <input type="number" name="price" placeholder="Price" class="border p-2 w-1/2 mb-2 rounded" min="0" step="0.01" required>
                </div>
                <textarea name="description" placeholder="Description" class="border p-2 h-24 w-full mb-2 rounded resize-none" required></textarea>
                <div class="flex justify-end mt-4">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded transition-transform hover:scale-105">
                        Salvar
                    </button>
                    <button type="button" onclick="fecharModal('create')" class="ml-2 text-gray-600 hover:underline">
                        Fechar
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>