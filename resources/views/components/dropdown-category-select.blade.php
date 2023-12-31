<div class="relative inline-block text-left text-sm" x-data="{ isOpen: false }" @click="isOpen=!isOpen" @click.away="isOpen=false">
  <div>
    <button type="button" class="inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-1 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-100" id="menu-button" aria-expanded="true" aria-haspopup="true">
      Categorías
      <!-- Heroicon name: mini/chevron-down -->
      <svg class="-mr-1 ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
      </svg>
    </button>
  </div>

  <!--
    Dropdown menu, show/hide based on menu state.

    Entering: "transition ease-out duration-100"
      From: "transform opacity-0 scale-95"
      To: "transform opacity-100 scale-100"
    Leaving: "transition ease-in duration-75"
      From: "transform opacity-100 scale-100"
      To: "transform opacity-0 scale-95"
  -->
  <div class="absolute right-0 z-10 mt-2 w-56 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" x-show="isOpen" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
    <div class="py-1" role="none">
      <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
      <a href="/dashboard/economia/filter" class="transition ease-in-out duration-150 hover:bg-blue-700 hover:text-white font-medium rounded-lg text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-0">Economía</button>
      <a href="/dashboard/entretenimiento/filter" class="hover:bg-blue-700 hover:text-white font-medium rounded-lg text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-2">Entretenimiento</a>
      <a href="/dashboard/politica/filter" class="hover:bg-blue-700 hover:text-white font-medium rounded-lg text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-3">Política</a>
      <a href="/dashboard/salud/filter" class="hover:bg-blue-700 hover:text-white font-medium rounded-lg text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-4">Salud</a>
      <a href="/dashboard/ciencia/filter" class="hover:bg-blue-700 hover:text-white font-medium rounded-lg text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-5">Ciencia</a>
      <a href="/dashboard/deportes/filter" class="hover:bg-blue-700 hover:text-white font-medium rounded-lg text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-6">Deportes</a>
      <a href="/dashboard/tecnologia/filter" class="hover:bg-blue-700 hover:text-white font-medium rounded-lg text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-7">Tecnología</a>
    </div>

    <div class="py-1" role="none">
      <a href="/dashboard/destacadas/filter" class="hover:bg-blue-700 hover:text-white font-medium rounded-lg text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-8">Destacados</a>
    </div>
  </div>
</div>
