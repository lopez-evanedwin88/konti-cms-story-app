<template>
  <section class="section">
    <div class="container">
      <h2 class="title">My Profile</h2>
      <div class="content">
        <p>
          <strong>Full name:</strong>
          {{ fullname }}
        </p>
        <p>
          <strong>Role:</strong>
          {{ role }}
        </p>
      </div>
    </div>
  </section>
</template>

<script>
import { userUserStore } from "~/store";

definePageMeta({
  middleware: 'auth'
});

export default {
  mounted() {
    const userStore = userUserStore();
    this.fullname = userStore.user.name;
    this.role = userStore.user.role;
  },
  data() {
    return {
      fullname: "",
      role: "",
      error: null,
    };
  },
};
</script>
