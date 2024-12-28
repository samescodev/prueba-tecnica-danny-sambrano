<script>
  import axios from 'axios';
  import { ref } from 'vue';


  export default {
    name: 'FormCrearPastel',
    data() {
      return {
        open: ref(false),
        idIngrediente: null,
        form: {
          nombre: '',
          descripcion: '',
          fecha_ingreso: '',
          fecha_vencimiento: '',
          id_categoria_ingrediente: null,
        },
        errores:{},
      };
    },
    methods: {
      validarFormulario(){
       this.errores = {};
          if(!this.form.nombre){
            this.errores.nombre = "El nombre es obligatorio";
          }
          if(!this.form.descripcion){
            this.errores.descripcion = "La descripción es obligatoria";
          }
          if(!this.form.fecha_ingreso){
            this.errores.fecha_ingreso = "La fecha de ingreso es obligatoria";
          }
          if(!this.form.fecha_vencimiento){
            this.errores.fecha_vencimiento = "La fecha de vencimiento es obligatoria";
          }
          if(this.form.fecha_ingreso > this.form.fecha_vencimiento){
            this.errores.fecha_vencimiento = "La fecha de vencimiento debe ser después de la fecha de ingreso.";
          }
          if(!this.form.id_categoria_ingrediente){
            this.errores.id_categoria_ingrediente = "Selecciona una categoria";
          }
          return Object.keys(this.errores).length === 0;
        },
        async enviarFormulario() {
          if(!this.validarFormulario()){
            console.log("El formulario no se ha enviado porque hay errores", this.errores);
            return;
          }
            try {
              const response = await axios.post("http://localhost:8000/api/ingrediente", this.form);
              console.log("Pastel creado con éxito:", response.data);
              this.idIngrediente = response.data.ingrediente.id_ingrediente;
              // Redirige a la página de pasteles u otra acción tras el éxito
              this.open = true;
          } catch (error) {
            console.error("Error al crear el pastel:", error);
          }
        }
    },
    mounted() {
      axios.get('http://localhost:8000/api/pastel')
      .then(response => {
        this.pasteles = response.data.pastel;
        console.log(this.pasteles);
        })
        .catch(error => {
          console.error('There was an error!', error);
      });
    }
  };
</script>

<template>
  <div>
    <form @submit.prevent="enviarFormulario" class="bg-white">
      <div class="space-y-12">
        <div class="border-b border-gray-900/10 pb-2">
          <h2 class="text-base/7 font-semibold text-gray-900">Ingresar un nuevo ingrediente</h2>
          <p class="mt-1 text-sm/6 text-gray-600">Rellena los datos para poder crear el ingrediente.</p>
  
          <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="sm:col-span-4">
              <label for="nombre" class="block text-sm/6 font-medium text-gray-900">Nombre del ingrediente</label>
              <div class="mt-2">
                <div class="flex items-center rounded-md bg-white pl-3 outline outline-1 -outline-offset-1 outline-gray-300 focus-within:outline focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600">
                  <input v-model="form.nombre" 
                        type="text" 
                        name="nombre" 
                        id="nombre" 
                        class="block min-w-0 grow py-1.5 pl-1 pr-3 text-base text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6" 
                        placeholder="Ingresa un nombre" />
                        
                </div>
                <p v-if="errores.nombre" class="text-red-500 text-xs">{{errores.nombre}}</p>
              </div>
            </div>
  
            <div class="col-span-full">
              <label for="descripcion" class="block text-sm/6 font-medium text-gray-900">Descripción</label>
              <div class="mt-2">
                <textarea 
                  v-model="form.descripcion"
                  name="descripcion" 
                  id="descripcion" 
                  rows="2" 
                  class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
              </div>
              
              <p v-if="errores.descripcion" class="text-red-500 text-xs">{{errores.descripcion}}</p>
            </div>

            <div class="sm:col-span-4">
              <label for="fecha_creación" class="block text-sm/6 font-medium text-gray-900">Fecha de ingreso</label>
              <div class="mt-2">
                <div class="flex items-center rounded-md bg-white pl-3 outline outline-1 -outline-offset-1 outline-gray-300 focus-within:outline focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600">
                  <input v-model="form.fecha_ingreso" type="date" name="fecha_creacion" id="fecha_creacion" class="block min-w-0 grow py-1.5 pl-1 pr-3 text-base text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6" />
                </div>
              </div>
              <p v-if="errores.fecha_ingreso" class="text-red-500 text-xs">{{errores.fecha_ingreso}}</p>
            </div>

            <div class="sm:col-span-4">
              <label for="fecha_vencimeinto" class="block text-sm/6 font-medium text-gray-900">Fecha de vencimiento</label>
              <div class="mt-2">
                <div class="flex items-center rounded-md bg-white pl-3 outline outline-1 -outline-offset-1 outline-gray-300 focus-within:outline focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600">
                  <input v-model="form.fecha_vencimiento" type="date" name="fecha_vencimiento" id="fecha_vencimiento" class="block min-w-0 grow py-1.5 pl-1 pr-3 text-base text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6"/>
                </div>
              </div>
              
              <p v-if="errores.fecha_vencimiento" class="text-red-500 text-xs">{{errores.fecha_vencimiento}}</p>
            </div>
            
            <div class="sm:col-span-4">
              
            <label for="country" class="block text-sm/6 font-medium  text-gray-900">Categoria</label>
            <div class="mt-2">
              <select v-model="form.id_categoria_ingrediente" id="categoria_ingredeinte" name="categoria_ingredeinte" autocomplete="country-name" class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
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
          </div>
        </div>
      </div>
  
      <div class="mt-2 flex items-center justify-end gap-x-6">
        <router-link :to="`/ingredientes`" class="text-sm/6 font-semibold text-gray-900">Cancelar</router-link>
        <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Crear ingrediente</button>
      </div>
    </form>
    <transition name="fade">
      <div
        v-if="open" 
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
      >
        <div class="bg-white rounded-lg shadow-lg p-6 w-100">
          <!-- Encabezado del modal -->
          <div class="flex justify-between items-center border-b pb-3">
            <h3 class="text-lg font-semibold">¡Ingrediente creado con éxito!</h3>
          </div>
       <!-- Pie del modal -->
       <div class="flex justify-end mt-6 space-x-2">
            <router-link 
            :to="`/ingredientes`"
              class="rounded-md text-blue-600 px-3 py-2 text-sm font-semibold shadow-sm hover:text-blue-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
            >
              Ver ingredientes
            </router-link >
            
            <router-link   
              v-if="idIngrediente"
              :to="`/ingrediente/${idIngrediente}`"
              class="rounded-md border border-indigo-600 text-indigo-600 px-3 py-2 text-sm font-semibold hover:text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
            >
              Ver detalle
            </router-link>  
        </div>
        </div>
      </div>
    </transition>
  </div>
</template>
  
