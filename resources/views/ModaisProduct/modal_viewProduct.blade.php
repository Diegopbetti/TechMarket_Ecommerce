<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @foreach ($products as $product)     
    <div id="view-{{ $product->id }}" class="fixed inset-0 items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-lg sm:w-1/3 w-[400px] shadow-lg">
            <h2 class="text-xl w-full text-center font-bold mb-4">Visualizar Produto</h2>
            <div>
                <div class="mb-2 flex  justify-between items-center">
                    <div class="flex items-center w-full flex-col-reverse sm:flex-row">
                        <input type="text" name="announcer" placeholder="Announcer" class="border p-2 w-1/2 mb-2 rounded" value="{{ $product->announcer->name }}" readonly>
                        <img src="{{ asset('storage/' . $product->photo) }}" alt="Foto do produto" class="sm:w-12 sm:h-12 w-[150px] h-[150px] rounded-full mb-[10px] sm:mb-0 object-cover ml-4">
                    </div>
                </div>
                <input type="text" name="name" placeholder="Name" class="border p-2 w-full mb-2 rounded" value="{{ $product->name }}" readonly>
                <div class="flex">
                    <input type="text" name="category" placeholder="Category" class="border p-2 w-1/2 mb-2 rounded" value="{{ $product->category }}" readonly>
                    <input type="number" name="price" placeholder="Price" class="border p-2 w-1/2 mb-2 rounded" min="0" value="{{ $product->price }}" readonly>
                </div>
                <textarea name="description" placeholder="Description" class="border p-2 h-24 w-full mb-2 rounded resize-none" readonly>{{ $product->description }}</textarea>
                <div class="flex justify-end mt-4">
                    <button type="button" onclick="fecharModal('view-{{ $product->id }}')" class="ml-2 text-gray-600 hover:underline">
                        Fechar
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</body>
</html>