<div class="bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
    <div>
        @if($post['status']=='publish')
        <figure class="relative max-w-sm transition-all duration-300 cursor-pointer filter grayscale-[30%] hover:grayscale-0">
        @else 
        <figure class="relative max-w-sm transition-all duration-300 cursor-pointer filter grayscale">
         @endif
            <a href="{{ $post['link'] }}">
                <img class="object-cover h-48 w-full rounded-t-lg" src="{{ $post['featuredMedia'] }}" alt="image description">
            </a>
            @if (App\Adapters\Api\WpApiAdapter::isDestacado($post) == true)
                <figcaption class="absolute bottom-2 px-2 text-sn text-white bg-red-500">
                    <p>Destacado</p>
                </figcatpion>
            @endif

        </figure>
    </div>

    <div class="p-5">
        <a href="{{ $post['link'] }}">
            <h5 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ Str::limit($post['title'],35) }}</h5>
        </a>
        <p class="mb-3 font-normal text-sm text-justify text-gray-700 dark:text-gray-400">{{ Str::limit($post['content'],95)}}</p>
        <div class="flex items-center gap-1 mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                </svg>

            <span class="text-sm underline decoration-double text-gray-800 dark:text-white decoration-sky-600">{{ $post['date'] }}</span>
            <span> | </span>
            @if($post['status']=='publish')
                <span class="text-sm underline decoration-wavy text-gray-800 dark:text-white decoration-green-600">{{ $post['status'] }}</span>
            @else
                <span class="text-sm underline decoration-wavy text-gray-800 dark:text-white decoration-red-600">{{ $post['status'] }}</span>
            @endif
        </div>
        <div class="flex items-center mb-3 gap-1">
            <span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
            </svg></span>
            
            @foreach ($post['categories'] as $category)                   
                @if( $category == "Destacadas" )
                    <span class="bg-red-100 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-800">{{ $category}}</span>
                @else
                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">{{ $category}}</span>
                @endif
            @endforeach
        </div> 
        
        <div class="flex justify-between items-center mb-3">
            <a href="https://infocarlospaz.com.ar/wp-admin/post.php?post={{ $post['id'] }}&action=edit" target="_blank" class="py-2 px-3 text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm text-center mr-2 mb-2">
                Editar
                </a>
 
            <form action="/post/{{ $post['id'] }}/destroy" method="post">
            @csrf
            @method('DELETE')
                <button type="submit" class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 shadow-lg shadow-green-500/50 dark:shadow-lg dark:shadow-green-800/80 font-medium rounded-lg text-sm px-3 py-2.5 text-center mr-2 mb-2">
                    @if ($post['status'] == "publish")
                        Draft
                    @else
                        Publicar
                    @endif
                </button>
            </form>
            <form action="/post/{{ $post['id'] }}/edit" method="post">
                @csrf
                @method('PATCH')
                @if(App\Adapters\Api\WpApiAdapter::isDestacado($post) == true)
                    <button type="submit" class="inline-flex items-center text-gray-900 bg-gradient-to-r from-lime-200 via-lime-400 to-lime-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-lime-300 dark:focus:ring-lime-800 shadow-lg shadow-lime-500/50 dark:shadow-lg dark:shadow-lime-800/80 font-medium rounded-lg text-sm px-3 py-2.5 text-center mr-2 mb-2">
                        No Destacar</button>
                @else
                    <button type="submit" class="inline-flex items-center text-gray-900 bg-gradient-to-r from-lime-200 via-lime-400 to-lime-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-lime-300 dark:focus:ring-lime-800 shadow-lg shadow-lime-500/50 dark:shadow-lg dark:shadow-lime-800/80 font-medium rounded-lg text-sm px-3 py-2.5 text-center mr-2 mb-2">
                        Destacar</button>                    
                @endif
            </form>
        </div>               
    </div>
</div>
