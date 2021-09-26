<template>
  <div class="img-bg rounded ">
    <!-- HEro -->
    <div class="pt-10">
        <h1 class="w-full text-center mx-auto py-16 px-20">
          Lorem, ipsum dolor sit amet consectetur adipisicing elit.
        </h1>
        <h2 class="w-full text-justify mx-auto px-16">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet quo laboriosam accusantium quisquam, voluptate, commodi fuga voluptatem magnam inventore eos cum perspiciatis tenetur nisi, rerum incidunt culpa. Officia, officiis quasi.
        </h2>
    </div>
    <!-- End of Hero -->
    <div class="px-5 pt-16 pb-40 flex flex-col sm:flex-row mx-auto justify-between w-full relative">
      <div class="sm:w-3/6 text-justify sm:my20 my-10">
        <h3>Lorem ipsum dolor sit amet consectetur adipisicing elit.</h3>
          <p> Eaque eius autem facilis omnis dignissimos officia eligendi unde beatae laudantium, cupiditate nam molestiae numquam perspiciatis veniam ab aliquam. Excepturi, a magnam.
                        Libero ab dolorum aliquam, laboriosam, rerum beatae enim voluptate eligendi sit, sint voluptates magni qui quis voluptatem rem quasi ea iusto vero quod eos eaque accusamus laborum magnam est! Veritatis.
                        Maxime corrupti aniearum aut asperiores consequuntur modi veritatis maxime iste? Labore magnam id velit quos doloribus molestias est veritatis! Tempora voluptas fuga illo vitae pariatur omnis suscipit eligendi quidem possimus optio.
          </p>
      </div>
      <div class="sm:w-1/6 text-justify">

      <!-- Keep this empty -->
      </div>
      <div class="sm:w-2/6 text-justify my-10 sm:mt-28">
        <h3>Lorem Ipsum Dolor</h3>
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit, harum et? Cupiditate, dolorem placeat, voluptatem dolores nemo magnam aspernatur praesentium maxime impedit neque hic rerum unde laborum. Placeat, ipsa magni.
          </p>
          <h3  class="mt-16">Lorem Ipsum Dolor</h3>
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit, harum et? Cupiditate, dolorem placeat, voluptatem dolores nemo magnam aspernatur praesentium maxime impedit neque hic rerum unde laborum. Placeat, ipsa magni.
          </p>
      </div>
      
    </div>

  </div>
</template>

<script>
export default {
  
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
  background-image: url('~@/assets/default-images/swift1980x1320.jpg');
  background-repeat: repeat-y;
  background-position: center;
}
</style>
