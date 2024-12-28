<template>
  <div class="bg-white">
    <div>
      <!-- Mobile filter dialog -->
      <TransitionRoot as="template" :show="mobileFiltersOpen">
        <Dialog class="relative z-40 lg:hidden" @close="mobileFiltersOpen = false">
          <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100" leave-to="opacity-0">
            <div class="fixed inset-0 bg-black/25" />
          </TransitionChild>

          <div class="fixed inset-0 z-40 flex">
            <TransitionChild as="template" enter="transition ease-in-out duration-300 transform" enter-from="translate-x-full" enter-to="translate-x-0" leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0" leave-to="translate-x-full">
              <DialogPanel class="relative ml-auto flex size-full max-w-xs flex-col overflow-y-auto bg-white py-4 pb-12 shadow-xl">
                <div class="flex items-center justify-between px-4">
                  <h2 class="text-lg font-medium text-gray-900">Filtros</h2>
                  <button type="button" class="-mr-2 flex size-10 items-center justify-center rounded-md bg-white p-2 text-gray-400" @click="mobileFiltersOpen = false">
                    <span class="sr-only">Cerrar menu</span>
                    <XMarkIcon class="size-6" aria-hidden="true" />
                  </button>
                </div>

                <!-- Filters -->
                <form class="mt-4 border-t border-gray-200">
                  <h3 class="sr-only">Categorias</h3>
                
                  <Disclosure as="div" v-for="section in filters" :key="section.id" class="border-t border-gray-200 px-4 py-6" v-slot="{ open }">
                    <h3 class="-mx-2 -my-3 flow-root">
                      <DisclosureButton class="flex w-full items-center justify-between bg-white px-2 py-3 text-gray-400 hover:text-gray-500">
                        <span class="font-medium text-gray-900">{{ section.name }}</span>
                        <span class="ml-6 flex items-center">
                          <PlusIcon v-if="!open" class="size-5" aria-hidden="true" />
                          <MinusIcon v-else class="size-5" aria-hidden="true" />
                        </span>
                      </DisclosureButton>
                    </h3>
                    <DisclosurePanel class="pt-6">
                      <div class="space-y-6">
                        <div v-for="(option, optionIdx) in section.options" :key="option.value" class="flex gap-3">
                          <div class="flex h-5 shrink-0 items-center">
                            <div class="group grid size-4 grid-cols-1">
                              <input :id="`filter-mobile-${section.id}-${optionIdx}`" :name="`${section.id}[]`" :value="option.value" type="checkbox" class="col-start-1 row-start-1 appearance-none rounded border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto" />
                              <svg class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-[:disabled]:stroke-gray-950/25" viewBox="0 0 14 14" fill="none">
                                <path class="opacity-0 group-has-[:checked]:opacity-100" d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path class="opacity-0 group-has-[:indeterminate]:opacity-100" d="M3 7H11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                              </svg>
                            </div>
                          </div>
                          <label :for="`filter-mobile-${section.id}-${optionIdx}`" class="min-w-0 flex-1 text-gray-500">{{ option.label }}</label>
                        </div>
                      </div>
                    </DisclosurePanel>
                  </Disclosure>
                </form>
              </DialogPanel>
            </TransitionChild>
          </div>
        </Dialog>
      </TransitionRoot>

      <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex items-baseline justify-between border-b border-gray-200 pb-6 pt-12">
          <h1 class="text-4xl font-bold tracking-tight text-gray-900">Agregar ingredientes</h1>

          <div class="flex items-center">
            <router-link :to="`/pastel/${idPastel}`" type="button" class="-m-2 ml-5 p-2 mr-4 text-gray-800 hover:text-gray-500 sm:ml-7">
              Cancelar
            </router-link>
            <button @click.prevent="agregarIngredientePastel" type="button" class="-m-2 ml-5 p-2 text-gray-800 hover:text-gray-500 sm:ml-7">
              Guardar
            </button>
            
            <button type="button" class="-m-2 ml-4 p-2 text-gray-400 hover:text-gray-500 sm:ml-6 lg:hidden" @click="mobileFiltersOpen = true">
              <span class="sr-only">Filtrar</span>
              <FunnelIcon class="size-5" aria-hidden="true" />
            </button>
          </div>
        </div>

        <section aria-labelledby="products-heading" class="pb-24 pt-6">
          <h2 id="products-heading" class="sr-only">Products</h2>

          <div class="grid grid-cols-1 gap-x-8 gap-y-10 lg:grid-cols-4">
            <!-- Filters -->
            <form class="hidden lg:block">
              <h3 class="sr-only">Categorias</h3>

              <Disclosure as="div" v-for="section in filters" :key="section.id" class="border-b border-gray-200 py-6" v-slot="{ open }">
                <h3 class="-my-3 flow-root">
                  <DisclosureButton class="flex w-full items-center justify-between bg-white py-3 text-sm text-gray-400 hover:text-gray-500">
                    <span class="font-medium text-gray-900">{{ section.name }}</span>
                    <span class="ml-6 flex items-center">
                      <PlusIcon v-if="!open" class="size-5" aria-hidden="true" />
                      <MinusIcon v-else class="size-5" aria-hidden="true" />
                    </span>
                  </DisclosureButton>
                </h3>
                <DisclosurePanel class="pt-6">
                  <div class="space-y-4">
                    <div v-for="(option, optionIdx) in section.options" :key="option.value" class="flex gap-3">
                      <div class="flex h-5 shrink-0 items-center">
                        <div class="group grid size-4 grid-cols-1">
                          <input :id="`filter-${section.id}-${optionIdx}`" :name="`${section.id}[]`" :value="option.value" type="checkbox" :checked="option.checked" class="col-start-1 row-start-1 appearance-none rounded border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto" />
                          <svg class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-[:disabled]:stroke-gray-950/25" viewBox="0 0 14 14" fill="none">
                            <path class="opacity-0 group-has-[:checked]:opacity-100" d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path class="opacity-0 group-has-[:indeterminate]:opacity-100" d="M3 7H11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                          </svg>
                        </div>
                      </div>
                      <label :for="`filter-${section.id}-${optionIdx}`" class="text-sm text-gray-600">{{ option.label }}</label>
                    </div>
                  </div>
                </DisclosurePanel>
              </Disclosure>
            </form>

            <!-- Product grid -->
            <div class="lg:col-span-3">
              <div class="lg:col-span-3">
                <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                  <div v-for="ingrediente in ingredientes" :key="ingrediente.id" class="group relative cursor-pointer">
                      <div 
                      
                            @click.prevent="agregarIngrediente(ingrediente)"
                      class="mt-4 flex justify-between rounded-lg p-4 hover:bg-gray-200 cursor:pointer"
                      :class="{
                        'bg-white': !ingredientesSeleccionados.some(item => item.id_ingrediente === ingrediente.id_ingrediente),
                        'bg-indigo-200': ingredientesSeleccionados.some(item => item.id_ingrediente === ingrediente.id_ingrediente)
                      }"
                      >
                        <div>
                          <h3 class="text-sm font-medium text-gray-900">
                            <button 
                            class="hover:underline focus:outline-none">
                              <span aria-hidden="true" class="sr-only">{{ ingrediente.nombre }}</span>
                              {{ ingrediente.nombre || 'Nombre no disponible' }}
                            </button>
                          </h3>
                          <p class="mt-1 text-sm text-gray-500">
                            {{ ingrediente.categoria_ingrediente.nombre || 'Sin fecha disponible' }}
                          </p>
                        </div>
                        <p class="text-sm text-gray-700">
                          <!-- Aquí puedes añadir contenido adicional si es necesario -->
                        </p>
                      </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </section>
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import {
  Dialog,
  DialogPanel,
  Disclosure,
  DisclosureButton,
  DisclosurePanel,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue';
import { XMarkIcon } from '@heroicons/vue/24/outline';
import { FunnelIcon, MinusIcon, PlusIcon } from '@heroicons/vue/20/solid';
import axios from 'axios';
import { useRoute, useRouter } from 'vue-router';

// Definir filtros como una constante reactiva
const filters = ref([
  {
    id: 'category',
    name: 'Categorias',
    options: [
      { value: 'Lacteos y derivados', label: 'Lacteos y derivados', checked: true },
      { value: 'Harinas', label: 'Harinas', checked: true },
      { value: 'Frutas', label: 'Frutas', checked: true },
      { value: 'Endulzantes', label: 'Endulzantes', checked: true },
      { value: 'Ingredientes basicos', label: 'Ingredientes básicos', checked: true },
      { value: 'Cacao y derivados', label: 'Cacao y derivados', checked: true },
      { value: 'Especias', label: 'Especias', checked: true },
      { value: 'Otros', label: 'Otros', checked: true },
    ],
  },
]);

// Declaración de variables reactivas
const ingredientes = ref([]); // Lista de ingredientes
const mobileFiltersOpen = ref(false); // Estado del filtro móvil
const ingredientesSeleccionados = ref([]); // Array de ingredientes seleccionados
const route = useRoute();
const router = useRouter();
const idPastel = computed(() => route.params.id);
const pastelIngredientes = ref({});
const ingredientesIds = ref([]);
console.log('ID del pastel:', idPastel.value);

const fetchPastel = async () => {
  try {
    const response = await axios.get(`http://localhost:8000/api/pastel/${idPastel.value}`);
    pastelIngredientes.value = response.data.pastel.ingredientes;
    console.log('Pastel:', pastelIngredientes.value);    
    // Si necesitas solo los ids de los ingredientes// Crear un objeto key-value con id_ingrediente como clave
      const ingredientesMap = pastelIngredientes.value.reduce((acc, ingrediente) => {
        acc[ingrediente.id_ingrediente] = {
          id_ingrediente: ingrediente.id_ingrediente,
          cantidad_ingrediente: ingrediente.pivot.cantidad_ingrediente,       // Aquí asignas la cantidad por defecto
          unidad_medida: ingrediente.pivot.unidad_medida,      // Aquí asignas la unidad de medida por defecto
        };
        return acc;
      }, {});
      
      const ingredientesArray = Object.values(ingredientesMap);
      ingredientesSeleccionados.value = ingredientesArray;
  console.log('Ingredientes seleccionados:', ingredientesSeleccionados.value);
  } catch (error) {
    console.error('Error al obtener los ingredientes del pastel:', error);
  }
};

// Función para obtener los ingredientes desde la API
const fetchIngredientes = async () => {
  try {
    const response = await axios.get('http://localhost:8000/api/ingrediente');
    ingredientes.value = response.data.ingredientes; // Guardar los datos en la variable reactiva
   
    
  } catch (error) {
    console.error('Error al obtener los ingredientes:', error);
  }
};
const ingredientesAgregados = ref(false); // Bandera para asegurarnos de que solo se ejecute una vez

const agregarIngrediente = ingrediente => {
  // Primero agregamos los ingredientes desde pastelIngredientes.value
  if(ingredientesAgregados.value == false){
    pastelIngredientes.value.forEach(item => {
    const ingredienteExistente = ingredientesSeleccionados.value.find(
      selectedItem => selectedItem.id_ingrediente === item.id_ingrediente
    );

    // Si no existe, agregamos el ingrediente con valores por defecto
    if (!ingredienteExistente) {
      ingredientesSeleccionados.value.push({
        id_ingrediente: item.id_ingrediente,
        cantidad_ingrediente: 1, // Valor por defecto
        unidad_medida: 'gramos', // Valor por defecto
      });
    }
    ingredientesAgregados.value = true;
  });

  }
 
  // Ahora agregamos o eliminamos el ingrediente que se pasa como parámetro
  const ingredienteExistente = ingredientesSeleccionados.value.find(
    item => item.id_ingrediente === ingrediente.id_ingrediente
  );

  if (ingredienteExistente) {
    // Si el ingrediente ya existe, lo eliminamos
    ingredientesSeleccionados.value = ingredientesSeleccionados.value.filter(
      item => item.id_ingrediente !== ingrediente.id_ingrediente
    );
  } else {
    // Si no existe, lo agregamos con valores por defecto
    ingredientesSeleccionados.value.push({
      id_ingrediente: ingrediente.id_ingrediente,
      cantidad_ingrediente: 1, // Valor por defecto
      unidad_medida: 'gramos', // Valor por defecto
    });
  }

  console.log('Ingredientes seleccionados:', ingredientesSeleccionados.value);
};


// Computed para filtrar ingredientes según la categoría seleccionada
const filteredIngredientes = computed(() => {
  // Obtener las categorías seleccionadas
  const selectedCategories = filters.value[0].options
    .filter(option => option.checked)
    .map(option => option.value);

  // Filtrar ingredientes que pertenecen a las categorías seleccionadas
  return ingredientes.value.filter(ingrediente =>
    selectedCategories.includes(ingrediente.categoria_ingrediente?.nombre)
  );
});

const agregarIngredientePastel = async () => {
  try {
    
    // Esperamos la respuesta de la petición PATCH
    const response = await axios.patch(
      `http://localhost:8000/api/pastel/${idPastel.value}/ingredientes`,
      { ingredientes: ingredientesSeleccionados.value }
    );

    
    router.push(`/pastel/${idPastel.value}`); // Redirigimos a la página del pastel

    // Si la petición es exitosa, logueamos la respuesta
    console.log('Ingredientes agregados al pastel:', response.data);

    // Limpiamos la lista de ingredientes seleccionados
    ingredientesSeleccionados.value = [];
  } catch (error) {
    // Si ocurre un error, lo logueamos
    console.error('Error al agregar ingredientes al pastel:', error);
  }
};

onMounted(() => {
  fetchIngredientes();
  fetchPastel();
});

</script>

