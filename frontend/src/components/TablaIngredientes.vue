<template>
    <div>
    <table class="min-w-full md:table">
		<caption class="text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white">
            
            <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400"></p>
        </caption>
		<thead class="block lg:table-header-group text-xs uppercase">
			<tr class="border border-grey-500 lg:border-none block md:table-row absolute -top-full lg:top-auto -left-full lg:left-auto  lg:relative ">
				<th scope="col" class="py-4" >Código</th>
				<th scope="col" class="py-4">Nombre</th>
				<th scope="col" class="py-4">Descripcion</th>
				<th scope="col" class="py-4">Fecha Ingreso</th>
				<th scope="col" class="py-4">Fecha vencimiento</th>
				<th scope="col" class="py-4">Categoria</th>
				<th scope="col" class="py-4"></th>
			</tr>
		</thead>
		<tbody class="block md:table-row-group">
			<tr v-for="ingrediente in ingredientes" :key="ingrediente.id_ingrediente" class="bg-white hover:opacity-75 cursor-default hover:bg-gray-100 hover:font-blod border-b block md:table-row">
				<td class="px-4 py-4  whitespace-nowrap block lg:table-cell"><span class="inline-block w-1/3 lg:hidden font-bold">Código</span>{{ ingrediente.id_ingrediente }}</td>
				<td class="px-2 py-4 font-base whitespace-nowrap block lg:table-cell"><span class="inline-block w-1/3 lg:hidden font-bold">Nombre</span>{{ ingrediente.nombre }}</td>
				<td class="px-2 py-4 font-base whitespace-nowrap block lg:table-cell"><span class="inline-block w-1/3 lg:hidden font-bold">Descripción</span>{{ ingrediente.descripcion }}</td>
				<td class="px-2 py-4 font-base whitespace-nowrap block lg:table-cell"><span class="inline-block w-1/3 lg:hidden font-bold">Fecha Ingreso</span>{{ ingrediente.fecha_ingreso }}</td>
				<td class="px-2 py-4 font-base whitespace-nowrap block lg:table-cell"><span class="inline-block w-1/3 lg:hidden font-bold">Fecha Vencimiento</span>{{ ingrediente.fecha_vencimiento }}</td>
				<td class="px-2 py-4 font-base whitespace-nowrap block lg:table-cell"><span class="inline-block w-1/3 lg:hidden font-bold">Categoria</span>{{ ingrediente.categoria_ingrediente.nombre }}</td>
				<td class="px-2 py-4 font-base whitespace-nowrap block lg:table-cell">
					<span class="inline-block w-1/3 lg:hidden font-bold">Actions</span>

					<router-link :to="`/ingrediente/${ingrediente.id_ingrediente}`"  class="p-2  hover:bg-blue-700 text-blue-700 hover:text-white font-base py-1 px-2 border border-blue-500 rounded">Ver detalles</router-link>
				</td>
			</tr>		
		</tbody>
	</table>

    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'TablaPastel',
    data() {
        return {
            ingredientes: []
        };
    },
    mounted() {
        axios.get('http://localhost:8000/api/ingrediente')
            .then(response => {
                this.ingredientes = response.data.ingredientes;
                console.log(this.ingredientes);
            })
            .catch(error => {
                console.error('There was an error!', error);
            });
    }
};
</script>
  