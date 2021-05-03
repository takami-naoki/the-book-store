import Vue from 'vue';
import VueRouter from 'vue-router';
import ExampleComponent from "./components/ExampleComponent";
import BooksCreate from "./views/BooksCreate";
import BooksShow from "./views/BooksShow";
import BooksEdit from "./views/BooksEdit";
import BooksIndex from "./views/BooksIndex";
import Logout from "./actions/Logout";

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        { path: '/', component: ExampleComponent, meta: { title: 'Welcome' } },
        { path: '/books', component: BooksIndex, meta: { title: 'Books' } },
        { path: '/books/create', component: BooksCreate, meta: { title: 'Add New Book' } },
        { path: '/books/:id', component: BooksShow, meta: { title: 'Detail for Book' } },
        { path: '/books/:id/edit', component: BooksEdit, meta: { title: 'Edit Book' } },
        { path: '/logout', component: Logout },
    ],
    mode: 'history'
});