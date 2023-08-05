<template>
  <div class="container">
    <div class="columns">
      <div class="column is-4 is-offset-4">
        <h2 class="title">Compose a story</h2>
        <form
          method="post"
          @submit.prevent="isCreate ? createStory($event) : updateStory($event)"
        >
          <div class="field">
            <label class="label">Title</label>
            <div class="control">
              <input
                type="text"
                class="input"
                name="title"
                v-model="title"
                required
              />
            </div>
          </div>
          <div class="field">
            <label class="label">Authors</label>
            <div class="control">
              <input
                type="text"
                class="input"
                name="authors"
                v-model="authors"
              />
            </div>
          </div>
          <div class="field">
            <label class="label">Content</label>
            <div class="control">
              <textarea
                class="textarea"
                placeholder="Type something here.."
                v-model="content"
                required
              ></textarea>
            </div>
          </div>
          <div class="control">
            <button
              type="submit"
              class="button"
              :class="isCreate ? 'is-success' : 'is-warning'"
            >
              {{ isCreate ? "Save" : "Update" }}
            </button>
            <button
              class="button is-primary is-pulled-right"
              @click="updateStatus"
              :class="(isCreate || this.status === 'Published') && 'is-hidden'"
            >
              Publish
            </button>
          </div>
        </form>
        <Notification :message="error" v-if="error" />
      </div>
    </div>
  </div>
</template>
<script>
import { userUserStore } from '~/store';

export default {
  data() {
    return {
      id: "",
      title: "",
      content: "",
      authors: "",
      status: "Draft",
      error: null,
      isCreate: true,
    };
  },
  mounted() {
    const route = useRoute();

    if (route.query.story) {
      this.isCreate = false;
      this.getStory(route.query.story);
    }
  },
  methods: {
    async createStory() {
      try {
        const userStore = userUserStore();
        const { success } = await useApiFetch("/stories", {
          method: "POST",
          body: {
            title: this.title,
            content: this.content,
            status: this.status,
            users_id: [1],
          },
          headers: {
            Authorization: `Bearer ${userStore.user.token}`,
          },
        });

        if (!success) {
          this.error = message;
        }

        this.$router.push("/dashboard");
      } catch (e) {
        this.error = e.response._data.message;
      }
    },
    async updateStory() {
      try {
        const userStore = userUserStore();
        const { success } = await useApiFetch(`/stories/${this.id}`, {
          method: "PUT",
          body: {
            title: this.title,
            content: this.content,
            status: this.status,
            users_id: [1],
          },
          headers: {
            Authorization: `Bearer ${userStore.user.token}`,
          },
        });

        if (!success) {
          this.error = message;
        }

        this.$router.push("/dashboard");
      } catch (e) {
        this.error = e.response._data.message;
      }
    },
    async getStory($id) {
      try {
        const userStore = userUserStore();
        const { data, success } = await useApiFetch(`/stories/${$id}`, {
          method: "GET",
          headers: {
            Authorization: `Bearer ${userStore.user.token}`,
          },
        });

        if (!success) {
          this.error = message;
        }

        this.id = data.id;
        this.title = data.title;
        this.content = data.content;
        this.status = data.status;
      } catch (e) {
        this.error = e.response._data.message;
      }
    },
    updateStatus() {
        this.status = "Published";
        this.updateStory();
    }
  },
};
</script>
