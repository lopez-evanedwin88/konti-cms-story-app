<template>
  <section class="section">
    <div class="container">
      <div class="columns">
        <div class="column is-4 is-offset-4">
          <h2 class="title has-text-centered">Register!</h2>

          <Notification :message="error" v-if="error" />

          <form method="post" @submit.prevent="register">
            <div class="field">
              <label class="label">Full name</label>
              <div class="control">
                <input
                  type="text"
                  class="input"
                  name="fullname"
                  v-model="fullname"
                  required
                />
              </div>
            </div>
            <div class="field">
              <label class="label">Email</label>
              <div class="control">
                <input
                  type="email"
                  class="input"
                  name="email"
                  v-model="email"
                  required
                />
              </div>
            </div>
            <div class="field">
              <label class="label">Password</label>
              <div class="control">
                <input
                  type="password"
                  class="input"
                  name="password"
                  v-model="password"
                  ref="password"
                  required
                />
              </div>
            </div>
            <div class="field">
              <label class="label">Confirm Password</label>
              <div class="control">
                <input
                  type="password"
                  class="input"
                  name="cpassword"
                  v-model="cpassword"
                  v-validate="'required|confirmed:password'"
                  data-vv-as="password"
                />
              </div>
            </div>
            <div class="field">
              <label class="label">Role Type</label>
              <div class="select is-rounded">
                <select v-model="role">
                  <option>User</option>
                  <option>Admin</option>
                </select>
              </div>
            </div>
            <div class="control">
              <button type="submit" class="button is-dark is-fullwidth">
                Register
              </button>
            </div>
          </form>

          <div class="has-text-centered" style="margin-top: 20px">
            Already got an account? <nuxt-link to="/login">Login</nuxt-link>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import Notification from "~/components/Notification";

export default {
  components: {
    Notification,
  },

  data() {
    return {
      fullname: "",
      username: "",
      email: "",
      password: "",
      cpassword: "",
      role: "User",
      error: null,
    };
  },

  methods: {
    async register() {
      try {
        if (this.password !== this.cpassword) {
          return (this.error =
            "Confirm password is not equal to password field");
        }

        const { success, message } = await useApiFetch("/register", {
          method: "POST",
          body: {
            name: this.fullname,
            email: this.email,
            password: this.password,
            c_password: this.cpassword,
            role: this.role,
          },
        });

        if (!success) {
          this.error = message;
        }
        this.$router.push("/login");

      } catch (e) {
        this.error = e.response._data.message;
      }
    },
  },
};
</script>
