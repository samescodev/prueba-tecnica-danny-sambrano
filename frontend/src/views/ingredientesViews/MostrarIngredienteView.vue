<script setup>
  import { ref, onMounted } from 'vue';
  import { useRoute, useRouter } from 'vue-router';
  import axios from 'axios';
  import Banner from '@/components/Banner.vue';

  const route = useRoute();
  const router = useRouter();
  const idIngrediente = route.params.id; 
  const editarValores = ref(false);
  const ingrediente = ref({
    categoria_ingrediente: [],
  });
  const notFoundPastel = ref(false);
  const loading = ref(true);
  const errores = ref({});
  const form = ref({
    nombre: '',
    descripcion: '',
    fecha_ingreso: '',
    fecha_vencimiento: '',
    id_categoria_ingrediente: null,
  });
  
  const eliminarPastel = () => {
    if (confirm('¿Estás seguro de que deseas eliminar este ingrediente? Esta acción no se puede deshacer.')) {
      axios
        .delete(`http://localhost:8000/api/ingrediente/${idIngrediente}`)
        .then(response => {
          console.log('Ingrediente eliminado:', response.data);
          router.push('/ingredientes');
        })
        .catch(error => {
            if(error.response.data.error == 23000){
                confirm('Este ingrediente no se puede eliminar por que esta siendo usado por otros pasteles\n elimine los pasteles que lo usan y vuelva a intentar');
            }
            console.error(error.response.data.error);
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
    if (!form.value.id_categoria_ingrediente) {
      errores.value.id_categoria_ingrediente = 'Ingresa una categoria es obligatorio';
    }
    if (!form.value.fecha_ingreso) {
      errores.value.fecha_ingreso = 'La fecha de ingreso es obligatoria';
    }
    if (!form.value.fecha_vencimiento) {
      errores.value.fecha_vencimiento = 'La fecha de vencimiento es obligatoria';
    }
    if (form.value.fecha_ingreso > form.value.fecha_vencimiento) {
      errores.value.fecha_vencimiento =
        'La fecha de vencimiento debe ser después de la fecha de ingreso.';
    }
    return Object.keys(errores.value).length === 0;
  };

  const enviarFormulario = async () => {
    if (!validarFormulario()) {
      console.log('El formulario no se ha enviado porque hay errores', errores.value);
      return;
    }
    try {
        console.log('form', form.value);
      const response = await axios.patch(`http://localhost:8000/api/ingrediente/${idIngrediente}`, form.value);
      editarValores.value = false;
      console.log('Ingrediente Actualizado:', response.data);
    } catch (error) {
      console.error('Error al crear el ingrediente:', error);
    }
  };
  
  onMounted(() => {
    axios
      .get(`http://localhost:8000/api/ingrediente/${idIngrediente}`)
      .then(response => {
        
        ingrediente.value = response.data.ingrediente;
        
        form.value.nombre = ingrediente.value.nombre;
        form.value.descripcion = ingrediente.value.descripcion;
        form.value.fecha_ingreso = ingrediente.value.fecha_ingreso;
        form.value.fecha_vencimiento = ingrediente.value.fecha_vencimiento;
        form.value.id_categoria_ingrediente = ingrediente.value.id_categoria_ingrediente;

        notFoundPastel.value = false;
        loading.value = false;
        console.log('ingredientes', ingrediente.value.ingredientes);
        console.log(ingrediente.value);
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
    <div>
        <Banner/>
        <div class="bg-gray-100  px-60 py-12">
            <div class="px-20 py-12 border border-gray-1 shadow-md p-4 flex flex-col justify-between leading-normal bg-white">
            <dl v-if="notFoundPastel === false">
                <dl v-if="loading === false">
                <form @submit.prevent="enviarFormulario" class="bg-white">
                    <div class="flex item-center justify-between">
                    <div class="px-4 sm:px-0">
                        <p class="mt-1 max-w-2xl text-sm/6 text-gray-500">Información del pastel</p>
                        <h3 class="text-base font-semibold text-gray-900">Codigo No. {{ ingrediente.id_ingrediente }}</h3> 
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
                        Editar Ingrediente
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
                                    v-model="form.fecha_ingreso"
                                    type="date" 
                                    name="nombre" 
                                    id="nombre" 
                                    class="block disabled:text-gray-500 min-w-0 grow py-1.5 pl-1 pr-3 disable:text-base text-bold text-indigo-700 disabled:text-gray-400 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6" 
                                    :disabled="!editarValores"
                                />
                            </div>
                        <p v-if="errores.fecha_ingreso" class="text-red-500 text-xs">{{errores.fecha_ingreso}}</p>
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

                        
                    <div class="sm:col-span-4">
                    
                    <label for="country" class="block text-sm/6 font-medium  text-gray-900">Categoria</label>
                    <div class="mt-2">
                        <select   :disabled="!editarValores" v-model="form.id_categoria_ingrediente" id="categoria_ingredeinte" name="categoria_ingredeinte" autocomplete="country-name" class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                        <option value="1">Lácteos y derivados</option>
                        <option value="2">Harinas</option>
                        <option value="3"> Frutas</option>
                        <option value="4">Endulzantes</option>
                        <option value="5">Ingredientes básicos</option>
                        <option value="6">Cacao y derivados</option>
                        <option value="7">Especias</option>
                        <option value="8">Otros</option>
                        </select>
                        
                        <p v-if="errores.id_categoria_ingrediente" class="text-red-500 text-xs">{{errores.id_categoria_ingrediente}}</p>
                    </div>
                    </div>
                    </dl>
                    </div>
                </form>
                        
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
                <h1 class="mt-4 text-balance text-5xl font-semibold tracking-tight text-gray-900 sm:text-7xl">Ingrediente no encontrado :(</h1>
                <p class="mt-6 text-pretty text-lg font-medium text-gray-500 sm:text-xl/8">Lamentamos informarte que no hemos podido localizar el ingrediente. Es posible que haya sido eliminado o que el código ingresado no exista.</p>
                <div class="mt-10 flex items-center justify-center gap-x-6">
                <router-link to="/ingredientes" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Ver ingredientes</router-link>
                </div>
            </div>
            </main>
            </dl>
            </div>
        </div>
    </div>
</template>