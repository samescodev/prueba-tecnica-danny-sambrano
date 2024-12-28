<template>
    <div class="bg-white">
        <div class="container mx-auto bg-white p-6">
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Pasteles -->
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
          <h2 class="text-xl font-semibold text-gray-700">Total de Pasteles</h2>
          <p class="mt-2 text-3xl font-bold text-blue-600">{{ pasteles }}</p>
        </div>
  
        <!-- Ingredientes -->
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
          <h2 class="text-xl font-semibold text-gray-700">Total de Ingredientes</h2>
          <p class="mt-2 text-3xl font-bold text-blue-600">{{ ingredientes }}</p>
        </div>
  
        <!-- Categorías -->
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
          <h2 class="text-xl font-semibold text-gray-700">Total de Categorías</h2>
          <p class="mt-2 text-3xl font-bold text-blue-600">{{ categorias }}</p>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
          <h2 class="text-xl font-semibold text-gray-700">Pasteles sin ingredientes</h2>
          <p class="mt-2 text-3xl font-bold text-blue-600">{{ pasteles_sin_ingrediente }}</p>
        </div>

            <!-- Gráfica de Ingredientes -->
        <div class="bg-white p-6 rounded-lg shadow-lg col-span-1 sm:col-span-2 lg:col-span-3">
          <h2 class="text-xl font-semibold text-gray-700">Ingredientes Menos</h2>
          <Bar v-if="loaded" :data="chartData" :options="chartOptions" />
        </div>
    
            <!-- Gráfica de Ingredientes -->
        <div class="bg-white p-6 rounded-lg shadow-lg col-span-1 sm:col-span-2 lg:col-span-3">
          <h2 class="text-xl font-semibold text-gray-700">Ingredientes Menos usados</h2>
          <Bar v-if="loaded" :data="chartData2" :options="chartOptions" />
        </div>
        </div>
        </div>
    </div>
  </template>
  
  <script>
    import axios from 'axios';
    import { Bar } from 'vue-chartjs'
    import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js';
// Registrar los componentes de Chart.js
ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);

  export default {
    components: {
      Bar,
    },
    data() {
    return {
      pasteles: 0,
      loaded: false,
      ingredientes: 0,
      categorias: 0,
      masUsados: [],
      menosUsados: [],
      pasteles_sin_ingrediente: 0,
      chartData: {
        labels: [], // Etiquetas para los ejes X
        datasets: [
        {   
            label: 'Más Usados', // Nombre del conjunto de datos
            data: [], // Datos para la gráfica
            backgroundColor: 'rgba(75, 192, 192, 0.2)', // Color de fondo
            borderColor: 'rgba(75, 192, 192, 1)', // Color del borde
            borderWidth: 1, // Grosor del borde
        }
        ],
    },
      chartOptions: {
        responsive: true
      },
      chartData2: {
        labels: [], // Etiquetas para los ejes X
        datasets: [
        {   
            label: 'Menos usados', // Nombre del conjunto de datos
            data: [], // Datos para la gráfica
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1, // Grosor del borde
        }
        ],
    },
    };
  },
    mounted() {
      // Llamar a las funciones que devuelven los datos de las APIs
      this.getCantidadPasteles();
      this.getCantidadIngredientes();
      this.getCantidadCategorias();
      this.getPastelesSinIngredientes();
      this.fetchIngredienteData();  
    },
    methods: {
      async getCantidadPasteles() {
        try {
          const response = await axios.get('http://localhost:8000/api/reportes/cantidad-pasteles');
          this.pasteles = response.data;
        } catch (error) {
          console.error('Error al obtener la cantidad de pasteles:', error);
        }
      },
      async getCantidadIngredientes() {
        try {
          const response = await axios.get('http://localhost:8000/api/reportes/cantidad-ingredientes');
          this.ingredientes = response.data;
        } catch (error) {
          console.error('Error al obtener la cantidad de ingredientes:', error);
        }
      },
      async getCantidadCategorias() {
        try {
          const response = await axios.get('http://localhost:8000/api/reportes/cantidad-categorias');
          this.categorias = response.data;
        } catch (error) {
          console.error('Error al obtener la cantidad de categorías:', error);
        }
      },
      
      async getPastelesSinIngredientes() {
        try {
          const response = await axios.get('http://localhost:8000/api/reportes/pasteles-sin-ingredientes');
          this.pasteles_sin_ingrediente = response.data;
        } catch (error) {
          console.error('Error al obtener la cantidad de categorías:', error);
        }
      },

      async fetchIngredienteData() {
      try {
        const response = await axios.get('http://localhost:8000/api/reportes/ingredientes-mas-usados');
        this.loaded = true;
        this.masUsados = response.data.masUsados;
        this.menosUsados = response.data.menosUsados;
        console.log(this.masUsados[0].nombre);
        if(this.masUsados.length == 0){
          this.masUsados = [{nombre: 'No hay ingredientes', cantidad: 0}];
        }else{

            this.chartData.labels = this.masUsados.map((ingrediente) => ingrediente.nombre);
            this.chartData.datasets[0].data = this.masUsados.map((ingrediente) => ingrediente.cantidad);
        }
        if(this.menosUsados.length == 0){
          this.menosUsados = [{nombre: 'No hay ingredientes', cantidad: 0}];
        }else{
            this.chartData2.labels = this.menosUsados.map((ingrediente) => ingrediente.nombre);
            this.chartData2.datasets[0].data = this.menosUsados.map((ingrediente) => ingrediente.cantidad);
        }

      } catch (error) {
        console.error('Error al obtener los ingredientes usados:', error);
      }
    },
    },
  };
  </script>
  
  <style scoped>
  /* Puedes agregar más estilos personalizados aquí si es necesario */
  </style>
  