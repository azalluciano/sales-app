<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Liste des Produits</h1>
        <router-link
            to="/products/create"
            class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block"
            >Ajouter Produit</router-link
        >
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">Nom</th>
                    <th class="border p-2">Description</th>
                    <th class="border p-2">Prix de détail</th>
                    <th class="border p-2">Prix de gros</th>
                    <th class="border p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="product in products" :key="product.id">
                    <td class="border p-2">{{ product.name }}</td>
                    <td class="border p-2">{{ product.description }}</td>
                    <td class="border p-2">{{ product.retail_price }}</td>
                    <td class="border p-2">{{ product.wholesale_price }}</td>
                    <td class="border p-2">
                        <router-link
                            :to="'/products/edit/' + product.id"
                            class="text-blue-500 mr-2"
                            >Modifier</router-link
                        >
                        <button
                            @click="deleteProduct(product.id)"
                            class="text-red-500"
                        >
                            Supprimer
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "ProductList",
    data() {
        return {
            products: [],
        };
    },
    mounted() {
        this.fetchProducts();
    },
    methods: {
        async fetchProducts() {
            const response = await axios.get("/api/products");
            this.products = response.data;
        },
        async deleteProduct(id) {
            if (confirm("Voulez-vous vraiment supprimer ce produit ?")) {
                await axios.delete(`/api/products/${id}`);
                this.fetchProducts();
            }
        },
    },
};
</script>
