<template>
  <div class="img-bg rounded px-5 flex flex-col sm:flex-row mx-auto justify-between z-10 relative">
    <div>
      <div class="lg:grid grid-rows-3 grid-flow-col gap-4 place-items-center sm:p-10 lg:pt-20 lg:px-16 mt-20">
        <div class="col-span-3">
          <h1 class="mb-2">Lorem ipsum dolor sit amet consectetur adipisicing elit.</h1>
          <p class="text-justify"> Eaque eius autem facilis omnis dignissimos officia eligendi unde beatae laudantium, cupiditate nam molestiae numquam perspiciatis veniam ab aliquam. Excepturi, a magnam.
                        Libero ab dolorum aliquam, laboriosam, rerum beatae enim voluptate eligendi sit, sint voluptates magni qui quis voluptatem rem quasi ea iusto vero quod eos eaque accusamus laborum magnam est! Veritatis.
                        Maxime corrupti animi qui, accusantium, amet mollitia cupiditate veniam accusamus debitis consectetur ipsa enim laudantium ad obcaecati veritatis dolor facilis delectus. Optio vitae dolor quidem beatae adipisci, animi nostrum sed!
                        Impedit earum aut asperiores consequuntur modi veritatis maxime iste? Labore magnam id velit quos doloribus molestias est veritatis! Tempora voluptas fuga illo vitae pariatur omnis suscipit eligendi quidem possimus optio.
          </p>
        </div>
        <div class="lg:row-span-2">
          <h1 class="mb-2">Sit amet consectetur adipisicing elit.</h1>
          <p class="text-justify"> Eaque eius autem facilis omnis dignissimos officia eligendi unde beatae laudantium, cupiditate nam molestiae numquam perspiciatis veniam ab aliquam. Excepturi, a magnam.
                        Libero ab 
                        upti animi qui, accusantium, amet mollitia cupiditate veniam accusamus debitis consectetur ipsa enim laudantium ad obcaecati veritatis dolor facilis delectus. Optio vitae dolor quidem beatae adipisci, animi nostrum sed!
                        Impedit eardolorum aliquam, laboriosam, rerum beatae enim voluptate eligendi sit, sint voluptates magni qui quis voluptatem rem quasi ea iusto vero quod eos eaque accusamus laborum magnam est! Veritatis.
                        Maxime corrupti animi qui, accusantium, amet mollitia cupiditate veniam accusamus debitis consectetur ipsa enim laudantium ad obcaecati veritatis dolor facilis delectus. Optio vitae dolor quidem beatae adipisci, animi nostrum sed!
                        Impedit earum aut asperiores consequuntur modi veritatis maxime iste? Labore magnam id velit quos doloribus molestias est veritatis! Tempora voluptas fuga illo vitae pariatur omnis suscipit eligendi quidem possimus optio.
          </p>
        </div>
        <div class="px-2">
          <img src="@/assets/default-images/cleaners.jpg" alt="">
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  head() {
    return {
      title: "Niešo o nás - Autodočista",
      meta: [
          {
            hid: 'og:url',
            property: 'og:url',
            content: `${process.env.baseUrl + '/about'}`
          },
          {
            hid: 'og:title',
            property: 'og:title',
            content: 'Sme progresívna spoločnosť zameraná na umývanie áut.'
          },
          {
            hid: 'og:description',
            property: 'og:description',
            content: 'Get to know all about Autodocista and its characters in tiny bits of info.'
          },
          {
            hid: 'og:image',
            property: 'og:image',
            content: `${process.env.baseUrl +'/shared-images/about-us.jpg'}`
          },
          {
            hid: 'og:image:secure_url',
            property: 'og:image:secure_url',
            content: `${process.env.baseUrl +'/shared-images/about-us.jpg'}`
          },
          {
            hid: 'og:image:alt',
            property: 'og:image:alt',
            content: 'Autodočista'
          }
      ]
    }
  }
}
</script>

<style scoped>
p {
  color: #e9e9ea;
  font-size: 0.85rem;
}
/* Sample `apply` at-rules with Tailwind CSS
.container {
@apply min-h-screen flex justify-center items-center text-center mx-auto;
}
*/
.img-bg {
  background-image: url('~@/assets/default-images/golf1920x1280.jpg');
  background-repeat: repeat-y;
  background-position: center;

}
</style>
