<template>
    <nav class="bg-gray-800 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <div class="text-lg font-bold">
                <router-link
                    to="/"
                    class="hover:text-gray-300"
                    active-class="text-blue-400 font-semibold"
                    exact-active-class="text-blue-400 font-semibold"
                >
                    SalesApp
                </router-link>
            </div>
            <div class="flex items-center space-x-4">
                <router-link
                    to="/users"
                    class="hover:text-blue-300 px-2 py-1 rounded transition-colors"
                    active-class="bg-blue-600 text-white font-semibold"
                >
                    Utilisateurs
                </router-link>
                <router-link
                    to="/clients"
                    class="hover:text-blue-300 px-2 py-1 rounded transition-colors"
                    active-class="bg-blue-600 text-white font-semibold"
                >
                    Clients
                </router-link>
                <router-link
                    to="/products"
                    class="hover:text-blue-300 px-2 py-1 rounded transition-colors"
                    active-class="bg-blue-600 text-white font-semibold"
                >
                    Produits
                </router-link>
                <router-link
                    to="/sales"
                    class="hover:text-blue-300 px-2 py-1 rounded transition-colors"
                    active-class="bg-blue-600 text-white font-semibold"
                >
                    Ventes
                </router-link>
                <router-link
                    to="/reports"
                    class="hover:text-blue-300 px-2 py-1 rounded transition-colors"
                    active-class="bg-blue-600 text-white font-semibold"
                >
                    Rapports
                </router-link>
                <span class="text-sm">
                    Connecté : {{ user?.name || "Utilisateur" }}
                </span>
                <button
                    @click="logout"
                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded transition-colors"
                >
                    Déconnexion
                </button>
            </div>
        </div>
    </nav>
</template>

<script>
import axios from "axios";
import { clearAuth, user } from "../auth";
import { useRouter } from "vue-router";

export default {
    name: "NavBar",
    setup() {
        const router = useRouter();

        async function logout() {
            try {
                await axios.post("/api/logout");
                clearAuth();
                router.push("/login");
            } catch (error) {
                alert(
                    "Erreur lors de la déconnexion : " +
                        (error.response?.data?.error || "Veuillez réessayer")
                );
                clearAuth();
                router.push("/login");
            }
        }

        return {
            user,
            logout,
        };
    },
};
</script>

<style scoped>
/* Style global pour les liens actifs si nécessaire */
.router-link-active {
    @apply bg-blue-600 text-white font-semibold;
}

/* Alternative avec CSS personnalisé */
.nav-link-active {
    background-color: #2563eb;
    color: white;
    font-weight: 600;
    border-radius: 0.25rem;
}
</style>
