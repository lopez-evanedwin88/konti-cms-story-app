// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  app: {
    layoutTransition: { name: 'layout', mode: 'out-in' },
    pageTransition: { name: 'page', mode: 'out-in' },
    head: {
      link: [
        {
          rel: 'stylesheet',
          href: 'https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.1/css/bulma.min.css'
        }
      ]
    },
  },
  runtimeConfig: {
    // Config within public will be also exposed to the client
    public: {
      BASE_API_URL: process.env.API_URL_SERVER,
      BASE_API_BROWSER_URL: process.env.API_URL_BROWSER
    }
  }
})
