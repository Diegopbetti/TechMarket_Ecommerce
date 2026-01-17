<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <main class="h-screen w-full bg-white flex flex-col justify-center items-center">
        <!-- Cabeçalho -->
        <div class="flex items-center justify-between">
            <h1 class=" text-blue-950 text-[32px] font-bold px-[10%] py-[1%] rounded-[20px] mb-5 whitespace-nowrap">
                Saque
            </h1>
        </div>

        <!-- Tabela -->
        <div class="">
            <table class="w-full overflow-hidden text-white rounded-[10px] border-collapse">
                <thead class="bg-blue-950">
                    <tr class="bg-[#237ecd] text-white">
                        <th class="px-3 py-2 text-center">Saldo</th>
                        <th class="px-3 py-2 text-center">Valor do Saque</th>
                    </tr>
                </thead>
                <tbody class="bg-blue-950">
                    <tr class="border-b border-gray-600">
                        <td class="px-3 py-2 text-center">R${{ number_format($balance, 2, ',', '.') }}</td>
                        <td class="px-3 py-2 text-center text-black">
                            <form action="{{ route('withdraw.process') }}" method="POST">
                                @csrf
                                <input type="number" name="value" class="w-[50px] mt:w-[150px] hm:w-[200px]"  min="0.01" step="0.01" required>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div>
            <button type="submit" class="bg-blue-950 text-white p-3 m-5 rounded-md cursor-pointer transition-transform duration-300 hover:scale-110">Efetuar Saque</button>
            </form>
        </div>
        @if(session('success'))
            <div class="text-green-500 mt-4">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="text-red-500 mt-4">
                {{ $errors->first() }}
            </div>
        @endif
    </main>
</body>
</html>
