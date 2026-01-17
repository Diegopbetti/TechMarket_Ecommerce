<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex flex-col items-center">
    <div class="flex flex-col md:flex-row justify-between items-center min-h-20 bg-blue-950 text-white w-full px-4 md:px-0 py-4 md:py-0">
        <h1 class="text-2xl md:text-3xl md:ml-10 mb-4 md:mb-0">TechMarket</h1>
        <div class="w-full md:w-auto">
            <form method="GET" action="{{ route('home_page') }}" class="flex flex-col md:flex-row items-center gap-2">
                <select name="category" class="bg-blue-950 text-white rounded-xl h-10 px-3 w-full md:w-auto">
                    <option value="">Todas as categorias</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                            {{ ucfirst($category) }}
                        </option>
                    @endforeach
                </select>

                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Pesquisar" class="bg-blue-950 text-white rounded-xl h-10 px-3 w-full md:w-auto">

                <button type="submit" class="underline transition-transform duration-300 hover:scale-110 md:mr-10">
                    Filtrar
                </button>
            </form>
        </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 w-11/12 sm:w-5/6 lg:w-1/2 mt-12 px-4 sm:px-0">
        @foreach($products as $product)
        <div class="flex flex-col items-center bg-blue-950 w-full sm:w-48 rounded-xl p-3 mx-auto">
            <img src="{{ asset('storage/' . $product->photo) }}" alt="{{$product->name}}" class="w-full sm:w-48 h-40 rounded-xl object-contain">
            <div class="flex flex-col w-full text-white mt-3">
                <div class="flex justify-between items-center w-full">
                    <span class="ml-1 font-bold text-sm sm:text-base">{{ $product->name }}</span>
                    <span class="mr-1 text-right text-sm sm:text-base">${{ $product->price }}</span>  
                </div>
                <div class="flex justify-between w-full mt-4">
                    <a href="{{ route('individual_page', $product->id) }}}" class="bg-blue-500 w-20 py-1 rounded-full text-xs font-bold text-center transition-transform duration-300 hover:scale-110">Visualizar</a>                         
                    @if (auth('web')->check())       
                        <form action="/checkout" method="POST" onsubmit="return verificarCompra(event, {{ $product->announcer_id }})">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="bg-blue-500 w-20 py-1 rounded-full text-xs font-bold text-center transition-transform duration-300 hover:scale-110">Comprar</button>
                        </form>                
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="flex flex-wrap justify-center m-8 w-full text-white px-4">
    @if ($products->currentPage() > 1)
        <a href="{{ $products->previousPageUrl() }}" class="bg-blue-500 mx-1 px-3 py-1 rounded-xl mb-2">
            <
        </a>
    @endif

    @for ($i = 1; $i <= $products->lastPage(); $i++)
        <a href="{{ $products->url($i) }}" 
           class="mx-1 px-3 py-1 rounded-xl mb-2
                  {{ $products->currentPage() == $i ? 'bg-blue-950 text-white' : 'bg-blue-500' }}">
            {{ $i }}
        </a>
    @endfor

    @if ($products->hasMorePages())
        <a href="{{ $products->nextPageUrl() }}" class="bg-blue-500 mx-1 px-3 py-1 rounded-xl mb-2">
            >
        </a>
    @endif
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