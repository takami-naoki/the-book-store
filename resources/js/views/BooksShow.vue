<template>
  <div>
    <div v-if="loading">Loading...</div>
    <div v-else>
      <div class="flex justify-between">
        <div class="text-blue-400">
          <a href="#" class="text-blue-400" @click="$router.back()">
            < Back
          </a>
          <!--        <div class="flex items-center pt-6">-->
          <!--          <UserCircle :name="book.name" />-->
          <!--          <p class="pl-5 text-xl">{{ book.title }}</p>-->
          <!--        </div>-->
          <p class="pt-6 text-gray-600 font-bold uppercase text-sm">Title</p>
          <p class="pt-2 text-blue-400">{{ book.title }}</p>
          <p class="pt-6 text-gray-600 font-bold uppercase text-sm">Description</p>
          <p class="pt-2 text-blue-400">{{ book.description }}</p>
          <p class="pt-6 text-gray-600 font-bold uppercase text-sm">Published At</p>
          <p class="pt-2 text-blue-400">{{ book.published_at }}</p>
        </div>
        <div class="relative">
          <router-link :to="'/books/' + book.book_id + '/edit'"
                       class="px-4 py-2 text-green-500 border border-green-500 text-sm font-bold mr-2 rounded">Edit
          </router-link>
          <a href="#" class="px-4 py-2 rounded text-sm text-red-500 border border-red-500 rounded"
             @click="modal = ! modal">Delete</a>
          <div v-if="modal" class="absolute bg-blue-900 text-white rounded-lg z-20 p-8 w-64 right-0 mt-2 mr-6">
            <p>Are you sure want to delete this record?</p>
            <div class="flex items-center mt-6 justify-end">
              <button class="text-white pr-4" @click="modal = ! modal">Cancel</button>
              <button class="px-4 py-2 bg-red-500 rounded text-sm font-bold text-white" @click="destroy">Delete</button>
            </div>
          </div>
        </div>
        <div v-if="modal" @click="modal = ! modal" class="bg-black opacity-25 absolute right-0 left-0 top-0 bottom-0 z-10"></div>
      </div>
    </div>
  </div>
</template>

<script>
import UserCircle from "../components/UserCircle";

export default {
  name: "BooksShow",
  mounted() {
    axios.get('/api/books/' + this.$route.params.id)
        .then(response => {
          this.book = response.data.data;
          this.loading = false
        })
        .catch(error => {
          this.loading = false
          if (error.response.status == 404) {
            this.$router.push('/books')
          }
        })
  },
  methods: {
    destroy: function () {
      axios.delete('/api/books/' + this.$route.params.id)
          .then(response => {
            this.$router.push('/books')
          })
          .catch(errros => {
            alert("Internal Error. Unable to delete book.")
          });
    }
  },
  components: {
    UserCircle
  },
  data: function () {
    return {
      book: null,
      modal: false,
      loading: true
    }
  }
}
</script>

<style scoped>

</style>