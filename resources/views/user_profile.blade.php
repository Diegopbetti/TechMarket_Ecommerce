<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Usuário</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex flex-col items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-lg  mm:w-fit lg:w-1/3">
        <h2 class="text-2xl font-bold mb-6 text-center">Perfil do Usuário</h2>
        
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Nome</label>
                <input type="text" value="{{ auth()->user()->name }}" class="border p-2 w-full rounded" readonly>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">E-mail</label>
                <input type="email" value="{{ auth()->user()->email }}" class="border p-2 w-full rounded" readonly>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Endereço</label>
                <input type="text" value="{{ auth()->user()->address }}" class="border p-2 w-full rounded" readonly>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Telefone</label>
                <input type="tel" value="{{ auth()->user()->telephone }}" class="border p-2 w-full rounded" readonly>
            </div>
            <div class="flex space-x-4">
                <div class="w-1/2">
                    <label class="block text-sm font-medium text-gray-700">Data de Nascimento</label>
                    <input type="date" value="{{ auth()->user()->birth_date }}" class="border p-2 w-full rounded" readonly>
                </div>
                <div class="w-1/2">
                    <label class="block text-sm font-medium text-gray-700">CPF</label>
                    <input type="text" value="{{ auth()->user()->cpf }}" class="border p-2 w-full rounded" readonly>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Saldo</label>
                <input type="number" value="{{ auth()->user()->balance }}" class="border p-2 w-full rounded" readonly>
            </div>
            <div class="flex items-center">
                <label class="block text-sm font-medium text-gray-700">Foto</label>
                <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Foto do usuário" class="w-12 h-12 rounded-full object-cover ml-4">
            </div>
        </div>

        <div class="flex justify-between mt-6">
            <button onclick="abrirModal('edit-{{ auth()->id() }}')" class="bg-[#FFC739] text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors">
                Editar
            </button>
            <button onclick="abrirModal('delete')" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition-colors">
                Excluir
            </button>
        </div>
    </div>

    <div id="edit-{{ auth()->id() }}" class="fixed inset-0 items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-lg w-1/3 shadow-lg">
            <h2 class="text-xl font-bold mb-4">Editar Usuário</h2>
            <form action="{{ route('user_profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nome</label>
                        <input type="text" name="name" value="{{ auth()->user()->name }}" class="border p-2 w-full rounded" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">E-mail</label>
                        <input type="email" name="email" value="{{ auth()->user()->email }}" class="border p-2 w-full rounded" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Endereço</label>
                        <input type="text" name="address" value="{{ auth()->user()->address }}" class="border p-2 w-full rounded" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Telefone</label>
                        <input type="tel" name="telephone" value="{{ auth()->user()->telephone }}" class="border p-2 w-full rounded" required>
                    </div>
                    <div class="flex space-x-4">
                        <div class="w-1/2">
                            <label class="block text-sm font-medium text-gray-700">Data de Nascimento</label>
                            <input type="date" name="birth_date" value="{{ auth()->user()->birth_date }}" class="border p-2 w-full rounded" required>
                        </div>
                        <div class="w-1/2">
                            <label class="block text-sm font-medium text-gray-700">CPF</label>
                            <input type="text" name="cpf" value="{{ auth()->user()->cpf }}" class="border p-2 w-full rounded" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Foto</label>
                        <input type="file" name="photo" class="border p-2 w-full rounded">
                    </div>
                </div>
                <div class="flex justify-end mt-4">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors">
                        Salvar
                    </button>
                    <button type="button" onclick="fecharModal('edit-{{ auth()->id() }}')" class="ml-2 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition-colors">
                        Fechar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="delete" class="fixed inset-0 items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-lg w-1/3 shadow-lg">
            <h2 class="text-xl font-bold mb-4">Excluir Usuário</h2>
            <form id="deleteForm" action="{{ route('user_profile.destroy') }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-between mt-4">
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition-colors">
                        Excluir
                    </button>
                    <button type="button" onclick="fecharModal('delete')" class="ml-2 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition-colors">
                        Fechar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function abrirModal(idModal) {
            document.getElementById(idModal).style.display = "flex";
        }

        function fecharModal(idModal) {
            document.getElementById(idModal).style.display = "none";
        }

        
    </script>
</body>
</html>