<template>
  <div class="img-bg p-5">
      <ul class="container text-gray-100 mx-auto sm:p-10 my-24">
          <li class="mb-8">
            <div class="flex justify-between">
                <h3 class="mb-2">
                    1. Lorem Ipsum Dolor sit amet, consectetur  adipiscing elit.             
                </h3>
                <h3 class="mb-2">$12.50</h3>
            </div>
            <p class="text-justify">
                ultrices id sapien, elit malesuada quisque senectus quis. Eu varius elementum id
                pulvinar tincidunt aliquam sit vel. Risus, id ultricies luctus nec nibh. Adipiscing amet orci lectus aenean egestas diam sed lobortis. Et nibh sapien amet risus ornare. Sociis diam scelerisque odio duis  dignissim volutpat id gravida.                                                                                                                                                                                                                                
            </p>
          </li>
          <li class="mb-8">
            <div class="flex justify-between">
                <h3 class="mb-2">
                    2. Lorem Ipsum Dolor sit amet, consectetur  adipiscing elit.             
                </h3>
                <h3 class="mb-2">$12.50</h3>
            </div>
            <p class="text-justify">
                ultrices id sapien, elit malesuada quisque senectus quis. Eu varius elementum id
                pulvinar tincidunt aliquam sit vel. Risus, id ultricies luctus nec nibh. Adipiscing amet orci lectus aenean egestas diam sed lobortis. Et nibh sapien amet risus ornare. Sociis diam scelerisque odio duis  dignissim volutpat id gravida.                                                                                                                                                                                                                                
            </p>
          </li>
          <li class="mb-8">
            <div class="flex justify-between">
                <h3 class="mb-2">
                    3. Lorem Ipsum Dolor sit amet, consectetur  adipiscing elit.             
                </h3>
                <h3 class="mb-2">$12.50</h3>
            </div>
            <p class="text-justify">
                ultrices id sapien, elit malesuada quisque senectus quis. Eu varius elementum id
                pulvinar tincidunt aliquam sit vel. Risus, id ultricies luctus nec nibh. Adipiscing amet orci lectus aenean egestas diam sed lobortis. Et nibh sapien amet risus ornare. Sociis diam scelerisque odio duis  dignissim volutpat id gravida.                                                                                                                                                                                                                                
            </p>
          </li>
          <li class="mb-8">
            <div class="flex justify-between">
                <h3 class="mb-2">
                    4. Lorem Ipsum Dolor sit amet, consectetur  adipiscing elit.             
                </h3>
                <h3 class="mb-2">$12.50</h3>
            </div>
            <p class="text-justify">
                ultrices id sapien, elit malesuada quisque senectus quis. Eu varius elementum id
                pulvinar tincidunt aliquam sit vel. Risus, id ultricies luctus nec nibh. Adipiscing amet orci lectus aenean egestas diam sed lobortis. Et nibh sapien amet risus ornare. Sociis diam scelerisque odio duis  dignissim volutpat id gravida.                                                                                                                                                                                                                                
            </p>
          </li>
          <li class="mb-8">
            <div class="flex justify-between">
                <h3 class="mb-2">
                    5. Lorem Ipsum Dolor sit amet, consectetur  adipiscing elit.             
                </h3>
                <h3 class="mb-2">$12.50</h3>
            </div>
            <p class="text-justify">
                ultrices id sapien, elit malesuada quisque senectus quis. Eu varius elementum id
                pulvinar tincidunt aliquam sit vel. Risus, id ultricies luctus nec nibh. Adipiscing amet orci lectus aenean egestas diam sed lobortis. Et nibh sapien amet risus ornare. Sociis diam scelerisque odio duis  dignissim volutpat id gravida.                                                                                                                                                                                                                                
            </p>
          </li>
      </ul>
  </div>
</template>

<script>
export default {
    name: "prices",
    head() {
        return {

            title: "Cenník služiem a programov - Autodočista",
            meta: [
                {
                hid: 'og:url',
                property: 'og:url',
                content: `${process.env.baseUrl +'/prices'}`
                },
                {
                hid: 'og:title',
                property: 'og:title',
                content: 'Viac ako priateľské ceny naších programov ručného umývania.'
                },
                {
                hid: 'og:description',
                property: 'og:description',
                content: 'Excepturi, a magnam. Libero ab dolorum aliquam, laboriosam, rerum beatae enim voluptate eligendi sit, sint voluptates magni qui quis voluptatem rem quasi ea iusto vero quod eos eaque '
                },
                {
                hid: 'og:image',
                property: 'og:image',
                content: `${process.env.baseUrl +'/shared-images/cennik.jpg'}`
                },
                {
                hid: 'og:image:secure_url',
                property: 'og:image:secure_url',
                content: `${process.env.baseUrl +'/shared-images/cennik.jpg'}`
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
.img-bg {
  background-image: url('~@/assets/default-images/octavia.jpg');
  background-repeat: repeat-y;
  background-position: center;
}

</style>