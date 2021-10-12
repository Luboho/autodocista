export default {
  env: {
    baseUrl: process.env.BASE_URL || 'https://www.autodocista.nl'
  },
  // Global page headers: https://go.nuxtjs.dev/config-head
  head: {
    // title: 'client',
    htmlAttrs: {
      lang: 'en'
    },
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      {
        hid: 'title',
        name: 'title',
        content: 'Sme progresívna spoločnosť zameraná na umývanie áut.'
      },
      {
        hid: 'keywords',
        name: 'keywords',
        content: 'umyvanie, upratovanie, aut, auta, cistenie, bratislava, kosice, zilina, poprad'
      },
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
    ],
    ['vue-social-sharing/nuxt', {
      networks: {
        fakeblock: 'https://fakeblock.com/share?url=@url&title=@title'
      }
    }],
  ],
  auth: {
    strategies: {
      'laravelSanctum': {
        provider: 'laravel/sanctum',
        // url: 'http://localhost:8000',
        url: 'https://api.autodocista.nl', // Works

        endpoints: {
          login: {url: '/api/login', method: 'post'},
          logout: {url: '/api/logout', method: 'post'},
          user: {url: '/api/user', method: 'get', propertyName: false}
          },
          tokenRequired: false,
          tokenType: false,
        } ,

        cookie: {
          cookie: {
            // (optional) If set, we check this cookie existence for loggedIn check
            name: 'XSRF-TOKEN',
          },
          endpoints: {
            // (optional) If set, we send a get request to this endpoint before login
            csrf: {
              url: 'https://api.autodocista.nl', // User for production
            }
          }
        },
      },

      redirect: {
        login: "/",
        logout: "/",
        home: "/"
      }
    },

  // Axios module configuration: https://go.nuxtjs.dev/config-axios
  axios: {
    // baseURL: 'http://localhost:8000',
    baseURL: 'https://api.autodocista.nl', // works
    credentials: true
  },

  // Build Configuration: https://go.nuxtjs.dev/config-build
  build: {
  }
}
