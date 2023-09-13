<x-app-layout>
    
    <x-slot name="header">
        <div class="flex items-end gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <x-dropdown-category-select class=""/>
        </div>
        
    </x-slot>
        <div class="grid grid-cols-4 py-4 px-4 gap-4">
            @foreach ($posts as $post)
                <x-post-card :post="$post"/>
            @endforeach
        </div> 
        <div class="flex items-center mb-4">
            {{ $posts->links() }}
        </div> 
</x-app-layout>
