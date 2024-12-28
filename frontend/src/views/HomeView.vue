<script setup>
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  import placeholderCake from '@/assets/img/placeholderCake.jpg';

  const placeholderImage = placeholderCake;
  const pasteles = ref([]);
  const fetchProducts = async () => {
    try {
      const response = await axios.get('http://localhost:8000/api/reportes/pasteles/recientes');
      pasteles.value = response.data;
    } catch (error) {
      console.error('Error al obtener los productos:', error);
    }
  };

  onMounted(fetchProducts);
</script>

<template>
  <div class="bg-white">
    <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
      <h2 class="text-2xl font-bold tracking-tight text-gray-900">Pasteles más recientes</h2>

      <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
        <div v-for="pastel in pasteles" :key="pastel.id" class="group relative">
        
          <img :src="placeholderImage" alt="Pastel" class="aspect-square w-full rounded-md bg-gray-200 object-cover group-hover:opacity-75 lg:aspect-auto lg:h-80" />
          <div class="mt-4 flex justify-between">
            <div>
              <h3 class="text-sm font-medium text-gray-900">
                <router-link :to="`/pastel/${pastel.id_pastel}`">
                  <span aria-hidden="true" class="absolute inset-0" />
                  {{ pastel.nombre }}
                </router-link>
              </h3>
              <p class="mt-1 text-sm text-gray-500">Fecha de caducidad: {{ pastel.fecha_vencimiento }}</p>
            </div>
            <p class="text-sm text-gray-700">
              </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
