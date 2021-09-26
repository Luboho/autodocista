<template>
    <div class="fixed z-40 bottom-0 h-10 flex w-10 mb-3 text-center slide justify-items-center">
        <ShareNetwork
            v-for="network in networks"
            :network="network.network"
            :key="network.network"
            :style="{backgroundColor: network.color, borderRadius: network.rounded, padding: network.padding, margin: network.margin }"
            :url="sharing.url"
            :title="sharing.title"
            :description="sharing.description"
            :quote="sharing.quote"
            :hashtags="sharing.hashtags"
            :twitterUser="sharing.twitterUser"
        >
            <!-- <i :class="network.icon"></i> -->
                <font-awesome-icon :icon="[network.prefix, network.icon]" class="text-lg text-white mt-0.5" />
                <!-- <span class="text-sm text-white">{{ network.name }}</span> -->
        </ShareNetwork>

    </div>
</template>

<script>
export default {
    head() {
        return {
            meta: [
                {
                    hid: 'og:image',
                    name: 'og:image',
                    property: 'og:image', 
                    content: '/swift.jpg',
                },
            ],
        }
    },
    data () {
        return {
        sharing: {
            url: 'https://autodocista.se',
            image: "~@/assets/default-images/swift1020x680.jpg",
            title: 'Auto DoČista. Nechajte svoje auto rozmaznať.',
            description: 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet quo laboriosam accusantium quisquam, voluptate, commodi fuga voluptatem magnam inventore eos cum perspiciatis tenetur nisi, rerum incidunt',
            quote: 'Lorem ipsum dolor sit amet consectetur',
            hashtags: 'autoDočista,autoumývarka,čisté-auto',
            twitterUser: 'auto-dočista'
        },
        networks: [
        //     { network: 'baidu', name: 'Baidu', icon: 'fas fah fa-lg fa-paw', color: '#2529d8' },
        //     { network: 'buffer', name: 'Buffer', icon: 'fab fah fa-lg fa-buffer', color: '#323b43' },
        //     { network: 'email', name: 'Email', icon: 'far fah fa-lg fa-envelope', color: '#333333' },
        //     { network: 'evernote', name: 'Evernote', icon: 'fab fah fa-lg fa-evernote', color: '#2dbe60' },
            { network: 'facebook', name: 'Facebook', prefix: 'fab', icon: 'facebook', color: '#1877f2', padding: '5px', rounded: '4px', margin: '4px' },
            // { network: 'flipboard', name: 'Flipboard', icon: 'fab fah fa-lg fa-flipboard', color: '#e12828' },
            // { network: 'hackernews', name: 'HackerNews', icon: 'fab fah fa-lg fa-hacker-news', color: '#ff4000' },
            // { network: 'instapaper', name: 'Instapaper', icon: 'fas fah fa-lg fa-italic', color: '#428bca' },
            // { network: 'line', name: 'Line', icon: 'fab fah fa-lg fa-line', color: '#00c300' },
            { network: 'linkedin', name: 'LinkedIn', prefix: 'fab', icon: 'linkedin', color: '#007bb5', padding: '5px', rounded: '4px', margin: '4px' },
            // { network: 'messenger', name: 'Messenger', icon: 'fab fah fa-lg fa-facebook-messenger', color: '#0084ff' },
            // { network: 'odnoklassniki', name: 'Odnoklassniki', icon: 'fab fah fa-lg fa-odnoklassniki', color: '#ed812b' },
            { network: 'pinterest', name: 'Pinterest',prefix: 'fab', icon: 'pinterest', color: '#bd081c', padding: '5px', rounded: '4px', margin: '4px' },
            // { network: 'pocket', name: 'Pocket', icon: 'fab fah fa-lg fa-get-pocket', color: '#ef4056' },
            // { network: 'quora', name: 'Quora', icon: 'fab fah fa-lg fa-quora', color: '#a82400' },
            // { network: 'reddit', name: 'Reddit', icon: 'fab fah fa-lg fa-reddit-alien', color: '#ff4500' },
            { network: 'skype', name: 'Skype', prefix: 'fab', icon: 'skype', color: '#00aff0', padding: '5px', rounded: '4px', margin: '4px' },
            // { network: 'sms', name: 'SMS', icon: 'far fah fa-lg fa-comment-dots', color: '#333333' },
            // { network: 'stumbleupon', name: 'StumbleUpon', icon: 'fab fah fa-lg fa-stumbleupon', color: '#eb4924' },
            // { network: 'telegram', name: 'Telegram', icon: 'fab fah fa-lg fa-telegram-plane', color: '#0088cc' },
            // { network: 'tumblr', name: 'Tumblr', icon: 'fab fah fa-lg fa-tumblr', color: '#35465c' },
            { network: 'twitter', name: 'Twitter', prefix: 'fab', icon: 'twitter', color: '#1da1f2', padding: '5px', rounded: '4px', margin: '4px' },
            { network: 'viber', name: 'Viber', prefix: 'fab', icon: 'viber', color: '#59267c', padding: '5px', rounded: '4px', margin: '4px' },
            // { network: 'vk', name: 'Vk', icon: 'fab fah fa-lg fa-vk', color: '#4a76a8' },
            // { network: 'weibo', name: 'Weibo', icon: 'fab fah fa-lg fa-weibo', color: '#e9152d' },
            { network: 'whatsapp', name: 'Whatsapp', prefix: 'fab', icon: 'whatsapp', color: '#25d366', padding: '5px', rounded: '4px', margin: '4px' },
            // { network: 'wordpress', name: 'Wordpress', icon: 'fab fah fa-lg fa-wordpress', color: '#21759b' },
            // { network: 'xing', name: 'Xing', icon: 'fab fah fa-lg fa-xing', color: '#026466' },
            // { network: 'yammer', name: 'Yammer', icon: 'fab fah fa-lg fa-yammer', color: '#0072c6' },
            // { network: 'fakeblock', name: 'Custom Network', icon: 'fab fah fa-lg fa-vuejs', color: '#41b883' }
        ]
        }
    }
}
</script>

<style scoped>
.slide {
    animation-duration: 3s;
  animation-name: slidein;
}
@keyframes slidein {
  from {
    margin-left: 100%;
    width: 300%;
  }

  to {
    margin-left: 0%;
    width: 100%;
  }
}
</style>