export default {
  // Global page headers: https://go.nuxtjs.dev/config-head
  head: {
    title: 'client',
    htmlAttrs: {
      lang: 'en'
    },
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: '' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' },
      { rel: "stylesheet", 
        href: "https://fonts.googleapis.com/css2?family=Lora&family=Montserrat&display=swap"
      }
    ]
  },

  // Global CSS: https://go.nuxtjs.dev/config-css
  css: [
    "~/assets/styles/fonts.css",
    "~/assets/styles/index.css",
    "~/assets/styles/inputs.css",
    "~/assets/styles/transitions.css"
  ],
  pageTransition: "fade", // to Override Nuxt.js default transition name "fade"
  //there are also to override transition: & layoutTransition:

  // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
  plugins: [
  ],

  // Auto import components: https://go.nuxtjs.dev/config-components
  components: true,

  // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
  buildModules: [
    '@nuxtjs/vuetify',
    // https://go.nuxtjs.dev/tailwindcss
    '@nuxtjs/tailwindcss',
  ],
  vuetify: {
    customVariables: ['~/assets/variables.scss']
  },

  // Modules: https://go.nuxtjs.dev/config-modules
  modules: [
    ['nuxt-gmaps', {
    key: '<API-Key>',
    //you can use libraries: ['places']
    }],
    // https://go.nuxtjs.dev/axios
    '@nuxtjs/axios',
    '@nuxtjs/auth-next',
    [
      'nuxt-fontawesome', {
        imports: [
         {
           set: '@fortawesome/free-solid-svg-icons',
           icons: ['fas']
         },
         {
           set:'@fortawesome/free-brands-svg-icons',
           icons: ['fab']
         }
       ]
      }
    ]
  ],
  auth: {
    strategies: {
      local: {
        provider: 'laravel/sanctum',
        url: 'http://localhost:8000',
        endpoints: {
          login: {url: '/api/login', method: 'post'},
          logout: {url: '/api/logout', method: 'post'},
          user: {url: '/api/user', method: 'get', propertyName: false}
          },
          tokenRequired: false,
          tokenType: false,
        } 
      },
      redirect: {
        login: "/dashboard",
        logout: "/",
        home: "/"
      }
    },

  // Axios module configuration: https://go.nuxtjs.dev/config-axios
  axios: {
    baseURL: 'http://localhost:8000',
    credentials: true
  },

  // Build Configuration: https://go.nuxtjs.dev/config-build
  build: {
  }
}
