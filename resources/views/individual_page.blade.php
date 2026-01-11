<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-screen w-full flex justify-center items-center">
    <div class="flex justify-center flex-col hm:flex-row items-center bg-blue-950 w-11/12  hm:h-5/6 rounded-2xl text-white hm:px-0 px-[10px]">
        <div class="hm:w-1/2 ms:h-[300px] ms:w-[300px] hm:h-full border-1 flex justify-center items-center">
            <img src="{{ asset('storage/' . $product->photo) }}" class="w-5/6 h-5/6 rounded-lg object-cover">
        </div>
        <div class="flex flex-col justify-center items-center w-full hm:w-1/2 hm:h-full">
            <div class="mm:w-96 mb-10">
                <span class="text-3xl font-bold size-14">{{$product->name}}:</span>
                <span class="text-2xl">R${{$product->price}}</span>
            </div>
            <div class="mm:w-96 mb-6">
                <span class="text-xl"> {{$product->description}} </span>
            </div>
            <div class="mm:w-96">
                <div class="mb-4 text-xl ">
                    <div class="">Autor: {{$product->announcer->name}}</div>
                    <div class="mt-3 ">Contato: {{$product->announcer->telephone}}</div>
                </div>
                <form action="/checkout" method="POST" onsubmit="return verificarCompra(event, {{ $product->announcer_id }})">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="text-2xl">                                
                    @if (auth('web')->check())       
                        <span class="">Quantidade: </span>
                        <input type="number" name="quantity" min="1" max="99" value="1" class="w-16 text-center text-black mr-8">
                        <button type="submit" class="bg-blue-500 w-24 py-2 rounded-full text-lg font-bold text-center transition-transform duration-300 hover:scale-110">Comprar</button>
                    @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
<script>
    function verificarCompra(event, sellerId) {
        const userId = {{ auth()->id() ?? 'null' }}; 
        
        if (userId === sellerId) {
            event.preventDefault(); 
            alert("Você não pode comprar seu próprio produto!");
            return false;
        }
        return true;
    }
</script>
</html>