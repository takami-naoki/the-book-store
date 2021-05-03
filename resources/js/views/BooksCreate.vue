<template>
  <div>
    <form @submit.prevent="submitForm">
      <InputField name="title" label="Book Title"
                  :errors="errors" placeholder="Book Title"
                  @update:field="form.title = $event"/>
      <InputField name="description" label="Description" :errors="errors"
                  placeholder="Description"
                  @update:field="form.description = $event"/>
      <InputField name="published_at" label="PublishedAt" :errors="errors"
                  placeholder="MM/DD/YYYY"
                  @update:field="form.published_at = $event"/>
      <div class="flex justify-end">
        <button class="py-2 px-4 rounded text-red-700 border mr-5  hover:border-red-400">Cancel</button>
        <button class="bg-blue-500 py-2 px-4 rounded text-white hover:bg-blue-400">Add New Book</button>
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
  methods: {
    submitForm: function () {
      axios.post('/api/books', this.form)
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