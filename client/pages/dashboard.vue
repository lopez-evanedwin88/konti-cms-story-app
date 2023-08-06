<template>
  <div class="container">
    <div class="columns">
      <div class="column is-4 is-offset-4">
        <div
          class="is-flex"
          style="justify-content: space-between; margin-top: 1rem"
        >
          <h2 class="title">Stories..</h2>
          <nuxt-link class="button is-success" to="/story"
            ><span class="icon is-small">
              <i class="fa fa-plus-square"></i>
            </span>
            <span>Compose story</span></nuxt-link
          >
        </div>
        <div class="mb-2" v-for="story in stories" :key="story.id">
          <div class="card" style="margin-bottom: 0.75rem">
            <div class="card-content">
              <div class="media">
                <div class="media-content">
                  <p class="title is-4">{{ story.title }}</p>
                </div>
              </div>
              <div class="content">
                {{ story.content }}
              </div>
              <label>{{ story.status }} ~ by Lorem Ipsum</label>
              <footer class="card-footer">
                <nuxt-link
                  class="card-footer-item"
                  :to="{
                    path: '/story',
                    query: { story: story.id },
                  }"
                  >View</nuxt-link
                >
              </footer>
            </div>
          </div>
        </div>
        <Notification :message="error" v-if="error" />
      </div>
    </div>
  </div>
</template>

<script>
import Notification from "~/components/Notification";
import { userUserStore } from "~/store";

definePageMeta({
  middleware: 'auth'
});

export default {
  components: {
    Notification,
  },

  data() {
    return {
      stories: [],
      error: null,
    };
  },

  methods: {
    async loadStories() {
      try {
        const userStore = userUserStore();
        const { data, success } = await useApiFetch("/stories", {
          method: "GET",
          headers: {
            Authorization: `Bearer ${userStore.user.token}`,
          },
        });

        if (!success) {
          this.error = message;
        }

        this.stories = data;
      } catch (e) {
        this.error = "Something is wrong with the server";
      }
    },
  },
  beforeMount() {
    this.loadStories();
  },
};
</script>
