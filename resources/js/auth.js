import { ref } from "vue";

export const isAuthenticated = ref(!!localStorage.getItem("token"));
export const user = ref(JSON.parse(localStorage.getItem("user")) || null);

export function setAuth(token, userData) {
    localStorage.setItem("token", token);
    localStorage.setItem("user", JSON.stringify(userData));
    isAuthenticated.value = true;
    user.value = userData;
}

export function clearAuth() {
    localStorage.removeItem("token");
    localStorage.removeItem("user");
    isAuthenticated.value = false;
    user.value = null;
}
