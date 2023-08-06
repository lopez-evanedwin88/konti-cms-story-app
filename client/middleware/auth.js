import { userUserStore } from "../store";

export default defineNuxtRouteMiddleware((to, from) => {
    const store = userUserStore();

    if (!store.user.token) {
      return navigateTo('/login');
    }
  });