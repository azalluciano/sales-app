<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Connexion</h1>
        <form @submit.prevent="login">
            <div class="mb-4">
                <label class="block text-gray-700">Email</label>
                <input
                    v-model="form.email"
                    type="email"
                    class="w-full border p-2"
                    required
                />
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Mot de passe</label>
                <input
                    v-model="form.password"
                    type="password"
                    class="w-full border p-2"
                    required
                />
            </div>
            <button
                type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded"
            >
                Se connecter
            </button>
            <router-link to="/register" class="ml-4 text-blue-500"
                >S'inscrire</router-link
            >
        </form>
    </div>
</template>

<script>
import axios from "axios";
import { setAuth } from "../../auth";

export default {
    name: "Login",
    data() {
        return {
            form: {
                email: "",
                password: "",
            },
        };
    },
    methods: {
        async login() {
            try {
                const response = await axios.post("/api/login", this.form);
                setAuth(response.data.token, response.data.user);
                axios.defaults.headers.common[
                    "Authorization"
                ] = `Bearer ${response.data.token}`;
                this.$router.push("/");
            } catch (error) {
                alert(
                    "Erreur lors de la connexion : " +
                        (error.response?.data?.error || "Veuillez réessayer")
                );
            }
        },
    },
};
</script>
