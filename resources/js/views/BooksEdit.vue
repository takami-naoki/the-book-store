<template>
  <div>
    <div class="flex justify-between">
      <a href="#" class="text-blue-400" @click="$router.back()">
        < Back
      </a>
    </div>
    <form @submit.prevent>
      <InputField name="title" label="Book Title"
                  :errors="errors" placeholder="Book Title"
                  @update:field="form.title = $event" :data="form.title"/>
      <InputField name="description" label="Description" :errors="errors"
                  placeholder="Description"
                  @update:field="form.description = $event" :data="form.description"/>
      <InputField name="published_at" label="PublishedAt" :errors="errors"
                  placeholder="MM/DD/YYYY"
                  @update:field="form.published_at = $event" :data="form.published_at"/>
      <div class="flex justify-end">
        <button class="py-2 px-4 rounded text-red-700 border mr-5  hover:border-red-400" @click="$router.back()">Cancel</button>
        <button class="bg-blue-500 py-2 px-4 rounded text-white hover:bg-blue-400" @click="submitForm">Save</button>
      </div>
    </form>
  </div>
</template>

<script>
import InputField from "../components/InputField";

export default {
  name: "BooksCreate",
  components: {
    InputField
  },
  data: function () {
    return {
      form: {
        'title': '',
        'description': '',
        'published_at': '',
      },
      errors: null
    }
  },
  mounted() {
    axios.get('/api/books/' + this.$route.params.id)
        .then(response => {
          this.form = response.data.data;
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
    submitForm: function () {
      axios.patch('/api/books/' + this.$route.params.id, this.form)
          .then(response => {
            this.$router.push(response.data.links.self)
          })
          .catch(errors => {
            this.errors = errors.response.data.errors;
          });
    }
  }
}
</script>

<style scoped>

</style>