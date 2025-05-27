<template>
    <div>
        <NavBar v-if="isAuthenticated" />
        <router-view />
    </div>
</template>

<script>
import NavBar from "./components/NavBar.vue";
import { isAuthenticated } from "./auth";

export default {
    name: "App",
    components: {
        NavBar,
    },
    setup() {
        return {
            isAuthenticated,
        };
    },
};
</script>

<style>
#app {
    font-family: Avenir, Helvetica, Arial, sans-serif;
    text-align: center;
}
</style>
