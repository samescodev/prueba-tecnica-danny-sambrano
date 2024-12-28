<script setup>
  import { ref, onMounted } from 'vue';
  import { useRoute } from 'vue-router';
  import axios from 'axios';

  const route = useRoute();
  const idPastel = route.params.id; 

  const pastel = ref([]);
  const notFoundPastel = ref(false); // Usar ref() para hacerlo reactivo
  const loading = ref(true);

  onMounted(() => {
    axios
      .get(`http://localhost:8000/api/pastel/${idPastel}`)
      .then(response => {
        
        pastel.value = response.data.pastel;
        
        notFoundPastel.value = false;
        loading.value = false;
        console.log(pastel.value);
      })
      .catch(error => {
        if (error.response) {
          switch (error.response.status) {
            case 404:
              console.error('Pastel no encontrado.');
              notFoundPastel.value = true;
              break;
            case 500:
              console.error('Error interno del servidor.');
              break;
            default:
              console.error(`Error inesperado: ${error.response.status}`);
          }
        } else if (error.request) {
          console.error('No se recibió respuesta del servidor. Verifica tu conexión.');
        } else {
          console.error('Ocurrió un error al realizar la solicitud:', error.message);
        }
        notFoundPastel = true;
      });

  });
</script>


<template >
  
  <div class="bg-gray-100  mx-auto px-4 py-12">
    <div class="px-20 py-12 border border-gray-1 shadow-md p-4 flex flex-col justify-between leading-normal bg-white">
      <dl v-if="notFoundPastel === false">
        <dl v-if="loading === false">
          <div class="flex item-center justify-between">
            <div class="px-4 sm:px-0">
              <p class="mt-1 max-w-2xl text-sm/6 text-gray-500">Información del pastel</p>
              <h3 class="text-base font-semibold text-gray-900">Codigo No. {{ pastel.id_pastel }}</h3> 
            </div>
            <div class="flex items-center">          
              <router-link   
                v-if="idPastel"
                :to="`/pastel/editar/${idPastel}`"
                class="rounded-md border border-indigo-600 text-indigo-600 px-3 py-2 text-sm font-semibold hover:text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
              >
                Editar Pastel
              </router-link>  
          </div>
          </div>
         
          <div class="mt-6 border-t border-gray-100">
            <dl class="divide-y divide-gray-100">
              <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm/6 font-medium text-gray-900">Nombre</dt>
                <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">{{ pastel.nombre }}</dd>
              </div>
              <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm/6 font-medium text-gray-900">Creado por</dt>
                <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">{{ pastel.preparado_por }}</dd>
              </div>
              <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm/6 font-medium text-gray-900">Descripcion</dt>
                <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">{{ pastel.descripcion }}</dd>
              </div>
              <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm/6 font-medium text-gray-900">Fecha de creación</dt>
                <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">{{ pastel.fecha_creacion }}</dd>
              </div>
              <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm/6 font-medium text-gray-900">Fecha de vencimiento</dt>
                <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">{{ pastel.fecha_vencimiento }}</dd>
              </div>
              
              <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm/6 font-medium text-gray-900">Estado</dt>
                <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">{{ pastel.estado }}</dd>
              </div>
              <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm/6 font-medium text-gray-900">Ingredientes</dt>
                <dd class="mt-2 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                  <ul role="list" class="divide-y divide-gray-100 rounded-md border border-gray-200">
                    <li v-for="(ingrediente, index) in pastel.ingredientes" :key="index" class="flex items-center justify-between py-4 pl-4 pr-5 text-sm/6">
                      <div class="flex w-0 flex-1 items-center">
                        <div class="ml-4 flex min-w-0 flex-1 gap-2">
                          <span class="truncate font-medium">{{ ingrediente.nombre }}</span>
                          <span class="shrink-0 text-gray-400">{{ ingrediente.pivot.cantidad_ingrediente  }} {{ ingrediente.pivot.unidad_medida  }}</span>
                        </div>
                      </div>
                    </li>
                  </ul>
                </dd>
              </div>
            </dl>
          </div>
        </dl>
        <dl v-if="loading">
          <div class="w-full mx-auto">
            <div class="animate-pulse space-y-4">
              
          <div class="px-4 sm:px-0">
            <p class="mt-1 max-w-2xl text-sm/6 text-gray-500">Información del pastel</p>
            <div class="h-6 bg-gray-300 rounded w-3/4"></div>
          </div>
          <div class="mt-6 border-t border-gray-100">
            <dl class="divide-y divide-gray-100">
              <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm/6 font-medium text-gray-900">Nombre</dt>
                <div class="h-6 bg-gray-300 rounded w-3/4"></div>
              </div>
              <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm/6 font-medium text-gray-900">Creado por</dt>
                <div class="h-6 bg-gray-300 rounded w-3/4"></div>
              </div>
              <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm/6 font-medium text-gray-900">Descripcion</dt>
                <div class="h-6 bg-gray-300 rounded w-3/4"></div>
              </div>
              <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm/6 font-medium text-gray-900">Fecha de creación</dt>
                <div class="h-6 bg-gray-300 rounded w-3/4"></div>
              </div>
              <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm/6 font-medium text-gray-900">Fecha de vencimiento</dt>
                <div class="h-6 bg-gray-300 rounded w-3/4"></div>
              </div>
              
              <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm/6 font-medium text-gray-900">Estado</dt>
                <div class="h-6 bg-gray-300 rounded w-3/4"></div>
              </div>
              <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm/6 font-medium text-gray-900">Ingredientes</dt>
                <dd class="mt-2 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                  <div class="h-6 bg-gray-300 rounded w-3/4"></div>
                </dd>
              </div>
            </dl>
          </div>
            </div>
          </div>

        </dl>
      </dl>
    <dl v-if="notFoundPastel">
      <main class="grid min-h-full place-items-center bg-white px-6 py-24 sm:py-32 lg:px-8">
      <div class="text-center">
        <p class="text-base font-semibold text-indigo-600">404</p>
        <h1 class="mt-4 text-balance text-5xl font-semibold tracking-tight text-gray-900 sm:text-7xl">Pastel no encontrado :(</h1>
        <p class="mt-6 text-pretty text-lg font-medium text-gray-500 sm:text-xl/8">Lamentamos informarte que no hemos podido localizar el pastel. Es posible que haya sido eliminado o que el código ingresado no exista.</p>
        <div class="mt-10 flex items-center justify-center gap-x-6">
          <router-link to="/pasteles" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Ver pasteles</router-link>
        </div>
      </div>
    </main>
    </dl>
    </div>
  </div>
</template>