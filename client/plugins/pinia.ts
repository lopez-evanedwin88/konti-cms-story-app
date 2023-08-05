import { userUserStore } from "../store";

export default defineNuxtPlugin(({ $pinia }) => {
  return {
    provide: {
      store: userUserStore($pinia),
    },
  };
});
