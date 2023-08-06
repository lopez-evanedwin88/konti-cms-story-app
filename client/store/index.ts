import { defineStore } from "pinia";

export const userUserStore = defineStore("userStore", {
  state: () => ({
    user: {
      id: "",
      token: "",
      name: "",
      role: "",
    },
  }),
  actions: {
    setUser($user: any) {
      this.user = {
        ...$user,
      };
    },
    purgeUser() {
      this.user = {
        id: "",
        token: "",
        name: "",
        role: "",
      };
    },
  },
  persist: {
    storage: persistedState.sessionStorage,
  },
});
