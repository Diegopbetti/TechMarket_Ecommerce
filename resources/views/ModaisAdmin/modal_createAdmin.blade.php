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
            <h2 class="text-xl font-bold mb-4">Criar Admin</h2>
            <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
                <input type="text" name="name" placeholder="Name" class="border p-2 w-full mb-2 rounded" required>
                <input type="email" name="email" placeholder="Email" class="border p-2 w-full mb-2 rounded" required>
                <input type="password" name="password" placeholder="Password" class="border p-2 w-full mb-2 rounded" required>
                <input type="text" name="address" placeholder="Address" class="border p-2 w-full mb-2 rounded" required>
                <input type="tel" name="telephone" placeholder="Telephone" class="border p-2 w-full mb-2 rounded" pattern="[0-9]{10,11}" required>
                <div class="flex">
                    <input type="date" name="birth_date" placeholder="Birth date" class="border p-2 w-1/3 mb-2 rounded" required>
                    <input type="text" name="cpf" placeholder="CPF" class="border p-2 w-2/3 mb-2 rounded" required>
                </div>
                <input type="file" name="photo" placeholder="Photo" class="border p-2 w-full mb-2 rounded" required>

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