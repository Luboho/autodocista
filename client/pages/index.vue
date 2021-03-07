<template>
  <div class="img-bg rounded px-5 flex flex-col sm:flex-row mx-auto justify-between w-full container text-sm z-10 p-2 relative">
    <div class="sm:w-1/3 text-justify my-16 sm:my-32">
      <h1>Lorem ipsum dolor sit amet consectetur adipisicing elit.</h1>
        <p> Eaque eius autem facilis omnis dignissimos officia eligendi unde beatae laudantium, cupiditate nam molestiae numquam perspiciatis veniam ab aliquam. Excepturi, a magnam.
                      Libero ab dolorum aliquam, laboriosam, rerum beatae enim voluptate eligendi sit, sint voluptates magni qui quis voluptatem rem quasi ea iusto vero quod eos eaque accusamus laborum magnam est! Veritatis.
                      Maxime corrupti animi qui, accusantium, amet mollitia cupiditate veniam accusamus debitis consectetur ipsa enim laudantium ad obcaecati veritatis dolor facilis delectus. Optio vitae dolor quidem beatae adipisci, animi nostrum sed!
                     Impedit earum aut asperiores consequuntur modi veritatis maxime iste? Labore magnam id velit quos doloribus molestias est veritatis! Tempora voluptas fuga illo vitae pariatur omnis suscipit eligendi quidem possimus optio.
        </p>
    </div>
    <div class="sm:w-1/3 text-justify">
    <!-- Keep this empty -->
    </div>
    <div class="sm:w-1/3 text-justify my-10 sm:mt-28">
      <h1>Lorem Ipsum Dolor</h1>
        <p>
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit, harum et? Cupiditate, dolorem placeat, voluptatem dolores nemo magnam aspernatur praesentium maxime impedit neque hic rerum unde laborum. Placeat, ipsa magni.
        </p>
        <h1  class="mt-16">Lorem Ipsum Dolor</h1>
        <p>
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit, harum et? Cupiditate, dolorem placeat, voluptatem dolores nemo magnam aspernatur praesentium maxime impedit neque hic rerum unde laborum. Placeat, ipsa magni.
        </p>
    </div>
    
  </div>
</template>

<script>
export default {}
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
