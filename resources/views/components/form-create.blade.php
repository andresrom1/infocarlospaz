<div class="p-4 w-full max-w-sm bg-white rounded-lg border border-gray-200 shadow-md sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">
    <form class="space-y-6" action="/post" method="POST">
        @csrf
        <h5 class="text-xl font-medium text-gray-900 dark:text-white">Crear post desde API</h5>
        <div>          
            <label for="categories" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Seleccioná la categoría</label>
            <select id="categories" name="categories" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option value="business">Economía</option>
            <option value="entertainment">Entretenimiento</option>
            <option value="general">Política</option>
            <option value="health">Salud</option>
            <option value="science">Ciencia</option>
            <option value="sports">Deportes</option>
            <option value="technology">Tecnología</option>

            </select>
        </div>
        <div class="mb-6">
            <label for="cantidad" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Cantidad</label>
            <input type="number" name="cantidad" id="cantidad" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        </div>
        <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Llamar NewsAPI</button>
        <div class="flex">
            <p class="text-sm">Para más información visitar: </p><a class="text-sm font-small text-blue-600 dark:text-blue-500 hover:underline" href="https://newsapi.org/docs/endpoints/sources">News API</a>
        </div>
    </form>
</div>