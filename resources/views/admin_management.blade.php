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
        <div class="flex items-center justify-between max-w-[1058px] w-full">
            <h1 class=" text-white text-[16px] sm:text-[24px] bg-blue-950 px-[10%] py-[1%] rounded-[20px] mb-5 whitespace-nowrap">
                {{ 'Gerenciamento de Admins: ' . \Auth::guard('admin')->user()->name }}                
            </h1>
            <button type="button" class="p-[1%] text-[60px] leading-[25px] flex border-white mb-5 text-blue-950 cursor-pointer" onclick="abrirModal('create')">
                +
            </button>
        </div>

        <!-- Tabela -->
        <div class="max-w-[1058px] w-full">
            <table class="w-full overflow-hidden text-white rounded-[10px] border-collapse">
                <thead class="bg-blue-950">
                    <tr class="bg-[#237ecd] text-white">
                        <th class="px-3 py-2 text-center">Id</th>
                        <th class="px-3 py-2 text-center">Name</th>
                        <th class="px-3 py-2 text-center hidden sm:table-cell">E-mail</th>
                        <th class="px-3 py-2 text-center">View</th>
                        <th class="px-3 py-2 text-center">Edit</th>
                        <th class="px-3 py-2 text-center">Delete</th>

                    </tr>
                </thead>
                <tbody class="bg-blue-950">
                    @foreach($admins as $admin)
                    <tr class="border-b border-gray-600">
                        <td class="px-3 py-2 text-center">{{$admin->id}}</td>
                        <td class="px-3 py-2 text-center">{{$admin->name}}</td>
                        <td class="px-3 py-2 text-center hidden sm:table-cell">{{$admin->email}}</td>
                        <th class="px-3 py-2 text-center"><button class="btn-acao bg-[#00AEA0] inline-flex items-center justify-center w-[20px] h-[20px] rounded-md border-none mt-1 cursor-pointer" onclick="abrirModal('view-{{ $admin->id }}')"></button></th>
                        <th class="px-3 py-2 text-center">
                            @if (auth('admin')->id() === $admin->id || auth('admin')->id() === $admin->admin_id)
                                <button class="btn-acao bg-[#FFC739] inline-flex items-center justify-center w-[20px] h-[20px] rounded-md border-none mt-1 cursor-pointer" onclick="abrirModal('edit-{{ $admin->id }}')"></button>
                            @endif
                        </th>
                        <th class="px-3 py-2 text-center">
                            @if (auth('admin')->id() === $admin->id || auth('admin')->id() === $admin->admin_id)
                                <button class="btn-acao bg-[#C70E3C] inline-flex items-center justify-center w-[20px] h-[20px] rounded-md border-none mt-1 cursor-pointer" onclick="abrirModal('delete-{{ $admin->id }}')"></button>
                            @endif
                        </th>
                    </tr>
                    @include('ModaisAdmin.modal_viewAdmin')
                    @include('ModaisAdmin.modal_editAdmin')
                    @include('ModaisAdmin.modal_deleteAdmin')
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="flex justify-center m-8 w-full text-white">
        @if ($admins->currentPage() > 1)
            <a href="{{ $admins->previousPageUrl() }}" class="bg-blue-500 mx-1 px-3 py-1 rounded-xl">
                <
            </a>
        @endif

        @for ($i = 1; $i <= $admins->lastPage(); $i++)
            <a href="{{ $admins->url($i) }}" 
            class="mx-1 px-3 py-1 rounded-xl 
                    {{ $admins->currentPage() == $i ? 'bg-blue-950 text-white' : 'bg-blue-500' }}">
                {{ $i }}
            </a>
        @endfor

        @if ($admins->hasMorePages())
            <a href="{{ $admins->nextPageUrl() }}" class="bg-blue-500 mx-1 px-3 py-1 rounded-xl">
                >
            </a>
        @endif
        </div>
        
        @include('ModaisAdmin.modal_createAdmin')
    </main>
    
    <script>
        function abrirModal(idModal){
            document.getElementById(idModal).style.display = "flex";
        }

        function fecharModal(idModal){
            document.getElementById(idModal).style.display = "none";
        }
    </script>
</body>
