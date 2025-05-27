<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">
            {{ isEdit ? "Modifier Produit" : "Ajouter Produit" }}
        </h1>
        <form @submit.prevent="submitForm">
            <div class="mb-4">
                <label class="block text-gray-700">Nom</label>
                <input
                    v-model="form.name"
                    type="text"
                    class="w-full border p-2"
                    required
                />
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Description</label>
                <textarea
                    v-model="form.description"
                    class="w-full border p-2"
                ></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Prix de détail</label>
                <input
                    v-model="form.retail_price"
                    type="number"
                    step="0.01"
                    class="w-full border p-2"
                    required
                />
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Prix de gros</label>
                <input
                    v-model="form.wholesale_price"
                    type="number"
                    step="0.01"
                    class="w-full border p-2"
                    required
                />
            </div>
            <button
                type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded"
            >
                Enregistrer
            </button>
            <router-link to="/products" class="ml-4 text-gray-500"
                >Annuler</router-link
            >
        </form>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "ProductForm",
    data() {
        return {
            form: {
                name: "",
                description: "",
                retail_price: "",
                wholesale_price: "",
            },
            isEdit: false,
        };
    },
    mounted() {
        if (this.$route.params.id) {
            this.isEdit = true;
            this.fetchProduct();
        }
    },
    methods: {
        async fetchProduct() {
            const response = await axios.get(
                `/api/products/${this.$route.params.id}`
            );
            this.form = response.data;
        },
        async submitForm() {
            try {
                if (this.isEdit) {
                    await axios.put(
                        `/api/products/${this.$route.params.id}`,
                        this.form
                    );
                } else {
                    await axios.post("/api/products", this.form);
                }
                this.$router.push("/products");
            } catch (error) {
                alert("Erreur lors de l'enregistrement");
            }
        },
    },
};
</script>
