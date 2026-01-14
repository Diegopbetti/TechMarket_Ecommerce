<body>
    @foreach ($users as $user)       
    <div id="view-{{ $user->id }}" class="fixed inset-0 items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-lg w-[400px] sm:w-1/3 shadow-lg">
            <h2 class="text-xl font-bold mb-4">Visualizar Usuário</h2>
                <input type="text" placeholder="Name" class="border p-2 w-full mb-2 rounded" value="{{$user->name}}" readonly>
                <input type="email" placeholder="Email" class="border p-2 w-full mb-2 rounded" value="{{$user->email}}" readonly>
                <input type="password" placeholder="Password" class="border p-2 w-full mb-2 rounded" value="{{$user->password}}" readonly>
                <input type="text" placeholder="Address" class="border p-2 w-full mb-2 rounded" value="{{$user->address}}" readonly>
                <input type="tel" placeholder="Telephone" class="border p-2 w-full mb-2 rounded" pattern="[0-9]{10,11}" value="{{$user->telephone}}" readonly>
                <div class="flex">
                    <input type="date" placeholder="Birth date" class="border p-2 w-1/3 mb-2 rounded" value="{{$user->birth_date}}" readonly>
                    <input type="text" placeholder="CPF" class="border p-2 w-2/3 mb-2 rounded" value="{{$user->cpf}}" readonly>
                </div>
                <input type="number" placeholder="Balance" class="border p-2 w-full mb-2 rounded" value="{{$user->balance}}" readonly>
                <div class="mb-2 flex justify-between items-center">
                    <div class="flex items-center">
                        <label class="block text-sm font-medium text-gray-700">Foto</label>
                        <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto do usuário" class="w-12 h-12 rounded-full object-cover ml-4">
                    </div>
                    <button type="button" onclick="fecharModal('view-{{ $user->id }}')" class="ml-2 text-gray-600 hover:underline">
                        Fechar
                    </button>
                </div>
        </div>
    </div>
    @endforeach
</body>