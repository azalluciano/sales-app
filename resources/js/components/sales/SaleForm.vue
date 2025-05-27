<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">
            {{ isEdit ? "Modifier Vente" : "Ajouter Vente" }}
        </h1>
        <form @submit.prevent="submitForm">
            <div class="mb-4">
                <label class="block text-gray-700">Client</label>
                <select
                    v-model="form.client_id"
                    class="w-full border p-2"
                    required
                >
                    <option
                        v-for="client in clients"
                        :key="client.id"
                        :value="client.id"
                    >
                        {{ client.name }}
                    </option>
                </select>
            </div>
            <div class="mb-4">
                <h2 class="text-lg font-bold">Produits</h2>
                <div
                    v-for="(item, index) in form.items"
                    :key="index"
                    class="flex mb-2"
                >
                    <select
                        v-model="item.product_id"
                        class="w-1/3 border p-2 mr-2"
                        @change="updateTotal(index)"
                    >
                        <option
                            v-for="product in products"
                            :key="product.id"
                            :value="product.id"
                        >
                            {{ product.name }}
                        </option>
                    </select>
                    <input
                        v-model.number="item.quantity"
                        type="number"
                        min="1"
                        class="w-1/3 border p-2 mr-2"
                        @input="updateTotal(index)"
                    />
                    <span class="w-1/3 p-2">{{ item.total || 0 }}</span>
                    <button
                        type="button"
                        @click="removeItem(index)"
                        class="text-red-500 hover:text-red-700"
                    >
                        Supprimer
                    </button>
                </div>
                <button
                    type="button"
                    @click="addItem"
                    class="bg-green-500 text-white px-4 py-2 rounded"
                >
                    Ajouter Produit
                </button>
            </div>
            <div class="mb-4">
                <strong>Total Général : {{ totalGeneral }}</strong>
            </div>
            <button
                type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded"
            >
                Enregistrer
            </button>
            <router-link to="/sales" class="ml-4 text-gray-500 hover:underline"
                >Annuler</router-link
            >
        </form>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "SaleForm",
    data() {
        return {
            form: {
                client_id: "",
                items: [{ product_id: "", quantity: 1, total: 0 }],
            },
            clients: [],
            products: [],
            isEdit: false,
        };
    },
    computed: {
        totalGeneral() {
            return this.form.items.reduce(
                (sum, item) => sum + (item.total || 0),
                0
            );
        },
    },
    mounted() {
        this.fetchClients();
        this.fetchProducts();
        if (this.$route.params.id) {
            this.isEdit = true;
            this.fetchSale();
        }
    },
    methods: {
        async fetchClients() {
            try {
                const response = await axios.get("/api/clients");
                this.clients = response.data;
            } catch (error) {
                alert(
                    "Erreur lors du chargement des clients : " +
                        (error.response?.data?.error || "Veuillez réessayer")
                );
            }
        },
        async fetchProducts() {
            try {
                const response = await axios.get("/api/products");
                this.products = response.data;
            } catch (error) {
                alert(
                    "Erreur lors du chargement des produits : " +
                        (error.response?.data?.error || "Veuillez réessayer")
                );
            }
        },
        async fetchSale() {
            try {
                const response = await axios.get(
                    `/api/sales/${this.$route.params.id}`
                );
                this.form = {
                    client_id: response.data.client_id,
                    items: response.data.items.map((item) => ({
                        product_id: item.product_id,
                        quantity: item.quantity,
                        total: item.total,
                    })),
                };
            } catch (error) {
                alert(
                    "Erreur lors du chargement de la vente : " +
                        (error.response?.data?.error || "Veuillez réessayer")
                );
            }
        },
        addItem() {
            this.form.items.push({ product_id: "", quantity: 1, total: 0 });
        },
        removeItem(index) {
            this.form.items.splice(index, 1);
        },
        updateTotal(index) {
            const item = this.form.items[index];
            const product = this.products.find((p) => p.id == item.product_id);
            if (product) {
                item.total = product.retail_price * item.quantity;
            }
        },
        async submitForm() {
            try {
                if (this.isEdit) {
                    await axios.put(
                        `/api/sales/${this.$route.params.id}`,
                        this.form
                    );
                } else {
                    await axios.post("/api/sales", this.form);
                }
                this.$router.push("/sales");
            } catch (error) {
                alert(
                    "Erreur lors de l'enregistrement : " +
                        (error.response?.data?.error || "Veuillez réessayer")
                );
            }
        },
    },
};
</script>
