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
            <div>
              <label class="label">Current Authors: </label>
              <span
                class="tag is-warning is-medium"
                style="margin-right: 0.5rem"
                v-if="isCreate === true"
              >
                Me
                <button class="delete is-small"></button>
              </span>
              <span
                class="tag is-warning is-medium"
                style="margin-right: 0.5rem"
                v-for="author in authors"
                :key="author.id"
                v-else
              >
                {{ author.id === currentUser.id ? "Me" : author.name }}
                <button class="delete is-small"></button>
              </span>
            </div>
            <div class="column">
              <label class="label">Invite other authors</label>
              <VueMultiselect
                placeholder="Search Author"
                label="name"
                track-by="id"
                :close-on-select="false"
                v-model="value"
                tag-placeholder="Add this as new user"
                :options="options"
                :multiple="true"
                :taggable="true"
                @tag="addTag"
              >
              </VueMultiselect>
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
import { userUserStore } from "~/store";
import VueMultiselect from "vue-multiselect";

definePageMeta({
  middleware: "auth",
});

export default {
  components: { VueMultiselect },
  data() {
    return {
      id: "",
      title: "",
      content: "",
      authors: [],
      status: "Draft",
      published_by: "",
      users_id: [],
      value: [],
      options: [],
      error: null,
      isCreate: true,
      currentUser: userUserStore().user,
    };
  },
  mounted() {
    this.loadusers();

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
            created_by: userStore.user.name,
            users_id: [userStore.user.id, ...this.value.map((u) => u.id)],
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
            published_by: this.published_by,
            users_id: [...this.users_id, ...this.value.map((u) => u.id)],
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
        this.users_id = data.users_id;
        this.currentUsersStory();
      } catch (e) {
        this.error = e.response._data.message;
      }
    },
    updateStatus() {
      const userStore = userUserStore();
      this.status = "Published";
      this.published_by = userStore.user.name;
      this.updateStory();
    },
    async loadusers() {
      try {
        const userStore = userUserStore();
        const { data, success } = await useApiFetch(`/users`, {
          method: "GET",
          headers: {
            Authorization: `Bearer ${userStore.user.token}`,
          },
        });

        if (!success) {
          this.error = message;
        }

        this.options = data;
      } catch (e) {
        this.error = e.response._data.message;
      }
    },
    async currentUsersStory() {
      try {
        const userStore = userUserStore();
        const { data, success } = await useApiFetch(
          `/userstories?${new URLSearchParams({
            users_id: [...this.users_id],
          })}`,
          {
            method: "GET",
            headers: {
              Authorization: `Bearer ${userStore.user.token}`,
            },
          }
        );

        if (!success) {
          this.error = message;
        }

        this.authors = data;
      } catch (e) {
        this.error = e.response._data.message;
      }
    },
    addTag(newTag) {
      const tag = {
        name: newTag,
        code: newTag.substring(0, 2) + Math.floor(Math.random() * 10000000),
      };
      this.options.push(tag);
      this.value.push(tag);
    },
  },
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>
