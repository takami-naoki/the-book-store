<template>
  <div>
    <div v-if="loading">Loading...</div>
    <div v-else>
      <div v-if="books.length === 0">
        <div>No Books yet. <router-link to="/books/create">Get Started ></router-link></div>
      </div>
      <div v-for="book in books">
<!--        <UserCircle :name="book.title" />-->
        <router-link :to="'/books/' + book.data.book_id" class="flex items-center border-b border-gray-400 p-4 hover:bg-gray-100">
          <div>
            <p class="text-sm font-bold text-gray-500">Book ID: {{ book.data.book_id }}</p>
            <p class="text-xl">{{ book.data.title }}</p>
            <p>{{ book.data.description }}</p>
          </div>
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
import UserCircle from "../components/UserCircle";
export default {
  name: "BooksIndex",
  components: {
    UserCircle
  },
  mounted() {
    axios.get('/api/books')
        .then(response => {
          this.books = response.data.data;
          this.loading = false;
        })
        .catch(error => {
          this.loading = false;
        })
  },
  data: function () {
    return {
      books: null,
      loading: true
    }
  }
}
</script>

<style scoped>

</style>