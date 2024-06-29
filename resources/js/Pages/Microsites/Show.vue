<template>
    <div>
        <h1>Detalles del Micrositio</h1>
        <p><strong>ID:</strong> {{ microsite.id }}</p>
        <p><strong>Nombre:</strong> {{ microsite.name }}</p>
        <p><strong>Tipo:</strong> {{ types[microsite.type] }}</p>
        <p><strong>Moneda:</strong> {{ currencies[microsite.currency] }}</p>
        <p><strong>Categoría:</strong> {{ categories[microsite.category_id] }}</p>
        <!-- Agrega más campos según sea necesario -->

        <router-link :to="{ name: 'microsites.index' }">Volver a la lista</router-link>
    </div>
</template>

<script>
export default {
    props: {
        microsite: Object,
        currencies: Object,
        types: Object,
        categories: Object,
    },
};
</script>
