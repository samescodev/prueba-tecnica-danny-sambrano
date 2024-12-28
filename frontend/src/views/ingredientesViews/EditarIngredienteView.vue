<template>
    <div>
        <h1 class="text-3xl font-bold underline">
        Editar Pastel
        </h1>
        <router-link to="/pastel-views/pastel-view-1">
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Pastel View 1
        </button>
        </router-link>
        <router-link to="/pastel-views/pastel-view-2">
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Pastel View 2
        </button>
        </router-link>
        <router-view></router-view>
    </div>
</template>