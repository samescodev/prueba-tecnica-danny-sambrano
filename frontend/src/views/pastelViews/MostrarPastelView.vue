<script setup>
  import { ref, onMounted } from 'vue';
  import { useRoute, useRouter } from 'vue-router';
  import axios from 'axios';

  const route = useRoute();
  const router = useRouter();
  const idPastel = route.params.id; 
  const editarValores = ref(false);
  const pastel = ref({
    ingredientes: [],
  });
  const notFoundPastel = ref(false);
  const loading = ref(true);
  const errores = ref({});
  const form = ref({
    nombre: '',
    descripcion: '',
    preparado_por: '',
    fecha_creacion: '',
    fecha_vencimiento: '',
  });
  
  const eliminarPastel = () => {
    if (confirm('¿Estás seguro de que deseas eliminar este pastel? Esta acción no se puede deshacer.')) {
      axios
        .delete(`http://localhost:8000/api/pastel/${idPastel}`)
        .then(response => {
          console.log('Pastel eliminado:', response.data);
          router.push('/pasteles');
        })
        .catch(error => {
          console.error('Error al eliminar el pastel:', error);
        });
    }
  };

  const hablititarEdicion = () => {
    editarValores.value = true;
  };
 const cancelarEdicion = () => {
    editarValores.value = false;
  };
  const validarFormulario = () => {
    errores.value = {};
    if (!form.value.nombre) {
      errores.value.nombre = 'El nombre es obligatorio';
    }
    if (!form.value.descripcion) {
      errores.value.descripcion = 'La descripción es obligatoria';
    }
    if (!form.value.preparado_por) {
      errores.value.preparado_por = 'El nombre del preparador es obligatorio';
    }
    if (!form.value.fecha_creacion) {
      errores.value.fecha_creacion = 'La fecha de creación es obligatoria';
    }
    if (!form.value.fecha_vencimiento) {
      errores.value.fecha_vencimiento = 'La fecha de vencimiento es obligatoria';
    }
    if (form.value.fecha_creacion > form.value.fecha_vencimiento) {
      errores.value.fecha_vencimiento =
        'La fecha de vencimiento debe ser después de la fecha de creación.';
    }
    return Object.keys(errores.value).length === 0;
  };

  const enviarFormulario = async () => {
    if (!validarFormulario()) {
      console.log('El formulario no se ha enviado porque hay errores', errores.value);
      return;
    }
    try {
      const response = await axios.patch(`http://localhost:8000/api/pastel/${idPastel}`, form.value);
      editarValores.value = false;
      console.log('Pastel Actualizado:', response.data);
    } catch (error) {
      console.error('Error al crear el pastel:', error);
    }
  };
  
  onMounted(() => {
    axios
      .get(`http://localhost:8000/api/pastel/${idPastel}`)
      .then(response => {
        
        pastel.value = response.data.pastel;
        
        form.value.nombre = pastel.value.nombre;
        form.value.descripcion = pastel.value.descripcion;
        form.value.preparado_por = pastel.value.preparado_por;
        form.value.fecha_creacion = pastel.value.fecha_creacion;
        form.value.fecha_vencimiento = pastel.value.fecha_vencimiento;
        
        notFoundPastel.value = false;
        loading.value = false;
        console.log('ingredientes', pastel.value.ingredientes);
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
  <div class="bg-gray-100  px-60 py-12">
    <div class="px-20 py-12 border border-gray-1 shadow-md p-4 flex flex-col justify-between leading-normal bg-white">
      <dl v-if="notFoundPastel === false">
        <dl v-if="loading === false">
          <form @submit.prevent="enviarFormulario" class="bg-white">
            <div class="flex item-center justify-between">
              <div class="px-4 sm:px-0">
                <p class="mt-1 max-w-2xl text-sm/6 text-gray-500">Información del pastel</p>
                <h3 class="text-base font-semibold text-gray-900">Codigo No. {{ pastel.id_pastel }}</h3> 
              </div>
              <div class="flex items-center">       
                <button   
                  v-if="!editarValores"
                  @click.prevent="eliminarPastel"
                  class="rounded-md mr-4 border border-red-600 text-red-600 px-3 py-2 text-sm font-semibold hover:text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                >
                  Borrar
                </button>         
                <button   
                  v-if="!editarValores"
                  @click.prevent="hablititarEdicion"
                  class="rounded-md border border-indigo-600 text-indigo-600 px-3 py-2 text-sm font-semibold hover:text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                >
                  Editar Pastel
                </button>  
                <button
                  v-if="editarValores"
                  @click.prevent="cancelarEdicion"
                  class="ml-2 mr-4 rounded-md border border-gray-400 text-gray-600 px-3 py-2 text-sm font-semibold hover:text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-400"
                >
                  Cancelar
                </button>
                <button   
                  v-if="editarValores"
                  type="submit"
                  class="rounded-md border border-indigo-600 text-indigo-600 px-3 py-2 text-sm font-semibold hover:text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                >
                  Guardar Cambios
                </button>  
            </div>
            </div>
          
            <div class="mt-6 border-t border-gray-100">
              <dl class="divide-y divide-gray-100">
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                  <dt class="text-sm/6 font-medium text-gray-900">Nombre</dt>
                  <div class="mt-2">
                    <div class="flex items-center rounded-md bg-white pl-3 outline outline-1 -outline-offset-1 outline-gray-300 focus-within:outline focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600">
                      <input
                            v-model="form.nombre"
                            type="text" 
                            name="nombre" 
                            id="nombre" 
                            class="block disabled:text-gray-500 min-w-0 grow py-1.5 pl-1 pr-3 disable:text-base text-bold text-indigo-700 placeholder:text-indigo-400 focus:outline focus:outline-0 " 
                            :disabled="!editarValores"
                          />
                    </div>
                   <p v-if="errores.nombre" class="text-red-500 text-xs">{{errores.nombre}}</p>
                  </div>
                </div>
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                  <dt class="text-sm/6 font-medium text-gray-900">Creado por</dt>   <div class="mt-2">
                    <div class="flex items-center rounded-md bg-white pl-3 outline outline-1 -outline-offset-1 outline-gray-300 focus-within:outline focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600">
                      <input
                        v-model="form.preparado_por"
                        type="text" 
                        name="nombre" 
                        id="nombre" 
                        class="block disabled:text-gray-500 min-w-0 grow py-1.5 pl-1 pr-3 disable:text-base text-bold text-indigo-700 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6" 
                        :disabled="!editarValores"
                       />
                    </div>
                   <p v-if="errores.preparado_por" class="text-red-500 text-xs">{{errores.preparado_por}}</p>
                  </div>
                </div>
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                  <dt class="text-sm/6 font-medium text-gray-900">Descripcion</dt>
                  <div class="mt-2">
                    <div class="flex items-center rounded-md bg-white pl-3 outline outline-1 -outline-offset-1 outline-gray-300 focus-within:outline focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600">
                      <textarea
                            v-model="form.descripcion"
                            type="text" 
                            name="nombre" 
                            id="nombre" 
                            class="block disabled:text-gray-500 min-w-0 grow py-1.5 pl-1 pr-3 disable:text-base text-bold text-indigo-700 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6" 
                            :disabled="!editarValores"
                          />
                    </div>
                   <p v-if="errores.descripcion" class="text-red-500 text-xs">{{errores.descripcion}}</p>
                  </div>
                </div>
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                  <dt class="text-sm/6 font-medium text-gray-900">Fecha de creación</dt>
                  <div class="mt-2">
                    <div class="flex items-center rounded-md bg-white pl-3 outline outline-1 -outline-offset-1 outline-gray-300 focus-within:outline focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600">
                      <input
                            v-model="form.fecha_creacion"
                            type="date" 
                            name="nombre" 
                            id="nombre" 
                            class="block disabled:text-gray-500 min-w-0 grow py-1.5 pl-1 pr-3 disable:text-base text-bold text-indigo-700 disabled:text-gray-400 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6" 
                            :disabled="!editarValores"
                          />
                    </div>
                   <p v-if="errores.fecha_creacion" class="text-red-500 text-xs">{{errores.fecha_creacion}}</p>
                  </div>
                </div>
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                  <dt class="text-sm/6 font-medium text-gray-900">Fecha de vencimiento</dt>
                  <div class="mt-2">
                    <div class="flex items-center rounded-md bg-white pl-3 outline outline-1 -outline-offset-1 outline-gray-300 focus-within:outline focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600">
                      <input
                            v-model="form.fecha_vencimiento"
                            type="date" 
                            name="nombre" 
                            id="nombre" 
                            class="block disabled:text-gray-500 min-w-0 grow py-1.5 pl-1 pr-3 disable:text-base text-bold text-indigo-700 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6" 
                            :disabled="!editarValores"
                          />
                    </div>
                   <p v-if="errores.fecha_vencimiento" class="text-red-500 text-xs">{{errores.fecha_vencimiento}}</p>
                  </div>
                </div>
              </dl>
            </div>
          </form>
          
           <div class="h-px flex-grow bg-gray-200"></div>
          
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="text-sm/6 font-medium text-gray-900">Ingredientes</dt>
              
                      <dd v-if="pastel.ingredientes.length" class="mt-2 shadow-900 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                        <router-link
                          :to="`/pastel/${idPastel}/agregar-ingredientes`"
                          class="rounded-md mb-2 p-2 border border-indigo-600 text-indigo-600 px-3 py-2 text-sm font-semibold hover:text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        >
                          Modificar Ingredientes
                        </router-link>  
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
                   
                    <dd v-else class="flex item-center justify-between mt-2 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                      <span class="truncate font-medium mr-4">No tienes ningun ingrediente en el pastel</span>
                      <router-link   
                          :to="`/pastel/${idPastel}/agregar-ingredientes`"
                          class="rounded-md border border-indigo-600 text-indigo-600 px-3 py-2 text-sm font-semibold hover:text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        >
                          Agregar Ingredientes
                      </router-link>  
                    </dd>
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