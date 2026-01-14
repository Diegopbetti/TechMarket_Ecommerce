<body>
    @foreach ($users as $user)       
    <div id="edit-{{ $user->id }}" class="fixed inset-0 items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-lg w-[400px] sm:w-1/3 shadow-lg">
            <h2 class="text-xl font-bold mb-4">Editar Usuário</h2>
            <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
                <input type="text" name="name" placeholder="Name" class="border p-2 w-full mb-2 rounded" value="{{$user->name}}" required>
                <input type="email" name="email" placeholder="Email" class="border p-2 w-full mb-2 rounded" value="{{$user->email}}" required>
                <input type="password" name="password" placeholder="Password" class="border p-2 w-full mb-2 rounded" value="{{$user->password}}" required>
                <input type="text" name="address" placeholder="Address" class="border p-2 w-full mb-2 rounded" value="{{$user->address}}" required>
                <input type="tel" name="telephone" placeholder="Telephone" class="border p-2 w-full mb-2 rounded" pattern="[0-9]{10,11}" value="{{$user->telephone}}" required>
                <div class="flex">
                    <input type="date" name="birth_date" placeholder="Birth date" class="border p-2 w-1/3 mb-2 rounded" value="{{$user->birth_date}}" required>
                    <input type="text" name="cpf" placeholder="CPF" class="border p-2 w-2/3 mb-2 rounded" value="{{$user->cpf}}" required>
                </div>
                <div class="mb-2 flex justify-between items-center">
                    <div class="flex items-center">
                        <input type="file" name="photo" placeholder="Photo" class="border p-2 w-full mb-2 rounded">
                        <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto do usuário" class="w-12 h-12 rounded-full object-cover ml-4">
                    </div>
                </div>
                <div class="flex justify-end mt-4">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded transition-transform hover:scale-105">
                        Editar
                    </button>   
                    <button type="button" onclick="fecharModal('edit-{{ $user->id }}')" class="ml-2 text-gray-600 hover:underline">
                        Fechar
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endforeach
</body>