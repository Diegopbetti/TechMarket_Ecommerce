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
    <div id="edit-{{ $admin->id }}" class="fixed inset-0 items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-lg w-[400px] sm:w-1/3 shadow-lg">
            <h2 class="text-xl font-bold mb-4">Editar Admin</h2>
            <form action="{{ route('admin.update', $admin->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
                <input type="text" name="name" placeholder="Name" class="border p-2 w-full mb-2 rounded" value="{{$admin->name}}" required>
                <input type="email" name="email" placeholder="Email" class="border p-2 w-full mb-2 rounded" value="{{$admin->email}}" required>
                <input type="password" name="password" placeholder="Password" class="border p-2 w-full mb-2 rounded" value="{{$admin->password}}" required>
                <input type="text" name="address" placeholder="Address" class="border p-2 w-full mb-2 rounded" value="{{$admin->address}}" required>
                <input type="tel" name="telephone" placeholder="Telephone" class="border p-2 w-full mb-2 rounded" pattern="[0-9]{10,11}" value="{{$admin->telephone}}" required>
                <div class="flex">
                    <input type="date" name="birth_date" placeholder="Birth date" class="border p-2 w-1/3 mb-2 rounded" value="{{$admin->birth_date}}" required>
                    <input type="text" name="cpf" placeholder="CPF" class="border p-2 w-2/3 mb-2 rounded" value="{{$admin->cpf}}" required>
                </div>
                <div class="mb-2 flex justify-between items-center">
                    <div class="flex items-center">
                        <input type="file" name="photo" placeholder="Photo" class="border p-2 w-full mb-2 rounded" required>
                        <img src="{{ asset('storage/' . $admin->photo) }}" alt="Foto do usuário" class="w-12 h-12 rounded-full object-cover ml-4">
                    </div>
                </div>
                <div class="flex justify-end mt-4">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded transition-transform hover:scale-105">
                        Editar
                    </button>   
                    <button type="button" onclick="fecharModal('edit-{{ $admin->id }}')" class="ml-2 text-gray-600 hover:underline">
                        Fechar
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endforeach
</body>
</html>