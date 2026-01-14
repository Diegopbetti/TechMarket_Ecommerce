<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @foreach ($admins as $admin)       
    <div id="view-{{ $admin->id }}" class="fixed inset-0 items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-lg w-[400px] sm:w-1/3 shadow-lg">
            <h2 class="text-xl font-bold mb-4">Visualizar Admin</h2>
                <input type="text" placeholder="Name" class="border p-2 w-full mb-2 rounded" value="{{$admin->name}}" readonly>
                <input type="email" placeholder="Email" class="border p-2 w-full mb-2 rounded" value="{{$admin->email}}" readonly>
                <input type="password" placeholder="Password" class="border p-2 w-full mb-2 rounded" value="{{$admin->password}}" readonly>
                <input type="text" placeholder="Address" class="border p-2 w-full mb-2 rounded" value="{{$admin->address}}" readonly>
                <input type="tel" placeholder="Telephone" class="border p-2 w-full mb-2 rounded" pattern="[0-9]{10,11}" value="{{$admin->telephone}}" readonly>
                <div class="flex">
                    <input type="date" placeholder="Birth date" class="border p-2 w-1/3 mb-2 rounded" value="{{$admin->birth_date}}" readonly>
                    <input type="text" placeholder="CPF" class="border p-2 w-2/3 mb-2 rounded" value="{{$admin->cpf}}" readonly>
                </div>
                <div class="mb-2 w-full flex sm:flex-row flex-col justify-between items-center">
                    <div class="flex items-center mb-[10px]">
                        <label class="block text-sm font-medium text-gray-700">Foto</label>
                        <img src="{{ asset('storage/' . $admin->photo) }}" alt="Foto do usuário" class="w-12 h-12 rounded-full object-cover ml-4">
                    </div>
                    <button type="button" onclick="fecharModal('view-{{ $admin->id }}')" class="ml-2 text-gray-600 hover:underline">
                        Fechar
                    </button>
                </div>
        </div>
    </div>
    @endforeach
</body>
</html>