<template>
    <div>
        <div v-if="loading" class="text-center">
            <i class="fas fa-sync-alt animate-spin"></i>
        </div>
        <template v-else>
            <div class="flex flex-col md:flex-row md:h-2/4">
                <div class="flex justify-center md:mr-5">
                    <div class="relative block">
                        <div v-if="book.discount" class="absolute inset-x-0 bottom-0 h-16 text-center">
                    <span class="text-red-600 rounded text-xl font-bold bg-white px-1">
                        <i class="fas fa-tags"></i> {{ book.discount + ' %' }}
                    </span>
                        </div>

                        <img :alt="book.title + ' ' + translation.cover"
                             :title="book.title"
                             :src="book.cover"
                             class="h-96">
                    </div>
                </div>
                <div class="flex-1 text-left">
                    <h1 class="text-3xl border-b-4 border-black">{{ book.title }}</h1>
                    <div class="flex flex-col md:flex-row justify-between">
                        <div class="mt-2">
                            <div>
                                <h2 class="text-xl inline">{{ translation.authors }}</h2>
                                <ul v-for="author in authors" class="ml-2 inline font-bold leading-9">
                                    <li class="inline m-1 bg-blue-100 p-1 rounded">{{ author.name }}</li>
                                </ul>
                            </div>
                            <div class="mt-3">
                                <h2 class="text-xl inline">{{ translation.genres }}</h2>
                                <ul v-for="genre in genres" class="ml-2 inline font-bold leading-9">
                                    <li class="inline m-1 bg-blue-100 p-1 rounded">{{ genre.title }}</li>
                                </ul>
                            </div>
                            <div class="mt-3">
                                <h2 class="text-xl inline">{{ translation.price }}</h2>
                                <span class="m-1 bg-blue-100 p-1 rounded">
                            <template v-if="book.price && book.discount">
                                <span class="line-through text-red-500">
                                    {{ roundCurrency(book.price) }}
                                </span>
                                 | {{ roundCurrency(book.price - (book.price * book.discount / 100)) }}
                            </template>
                            <template v-else-if="book.price">
                                    {{ roundCurrency(book.price) }}
                            </template>
                             <template v-else>
                                    {{ translation.free }}
                            </template>
                        </span>
                            </div>
                        </div>
                        <div>
                            <book-rating
                                :average-rating="averageRating"
                                :raters-count="ratersCount"
                                :store-route="ratingStoreRoute"
                                :destroy-route="ratingDestroyRoute"
                                :user-rating="userRating">
                            </book-rating>

                            <div v-if="authorized" class="text-center">
                                <div v-if="user.is_admin && book.approved_at === null && !this.approved"
                                     class="text-green-400">
                                    <button @click.prevent="approveBook"
                                            class="focus:outline-none hover:text-green-200">
                                        <i class="fas fa-check-square"></i>
                                        <span>{{ translation.approve }}</span>
                                    </button>
                                </div>
                                <span v-else-if="this.approved" class="bg-green-100">
                            {{ translation.approve_success }}
                        </span>
                            <span v-else-if="this.approved === false" class="bg-red-100">
                            {{ translation.approve_failed }}
                        </span>
                                <template v-if="user.is_admin || user.id === book.user_id">
                                    <div class="text-red-400 hover:text-red-200">
                                        <form :action="bookDestroyRoute"
                                              method="post">
                                            <slot></slot>
                                            <input type="hidden" name="_method" value="delete"/>
                                            <button class="focus:outline-none"
                                                    onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-ban"></i>
                                                <span>{{ translation.delete }}</span>
                                            </button>
                                        </form>
                                    </div>
                                    <a :href="bookEditRoute"
                                       class="block mb-0 mr-0 text-indigo-500 hover:text-indigo-300
                                        background-transparent font-bold uppercase
                                        py-1 text-sm outline-none focus:outline-none">
                                        <i class="fas fa-edit"></i> {{ translation.edit }}
                                    </a>
                                </template>
                                <a :href="bookReportRoute"
                                   class="text-indigo-500 hover:text-indigo-300
                                        background-transparent font-bold uppercase
                                        py-1 text-sm outline-none focus:outline-none">
                                    <i class="fas fa-bug"></i> {{ translation.report }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <p class="h-3/4 text-2xl md:text-left mt-1 md:mt-0">
                        {{ book.description }}
                    </p>
                </div>
            </div>
            <review
                :translation="translationReview"
                :store-route="reviewStoreRoute"
                :reviews="reviews"
                :register-route="registerRoute"
                :login-route="loginRoute"
                :user="user"
                @newReview="loadBook">
            </review>
        </template>
    </div>
</template>

<script>
export default {
    props: {
        translation: {
            type: Object,
            required: true
        },
        translationReview: {
            type: Object,
            required: true
        },
        bookLoadRoute: {
            type: String,
            required: true
        },
        userRoute: {
            type: String,
        },
        ratingStoreRoute: {
            type: String,
        },
        ratingDestroyRoute: {
            type: String,
        },
        reviewStoreRoute: {
            type: String,
        },
        bookReportRoute: {
            type: String,
        },
        bookApproveRoute: {
            type: String,
        },
        bookDestroyRoute: {
            type: String,
        },
        bookEditRoute: {
            type: String,
        },
        registerRoute: {
            type: String,
        },
        loginRoute: {
            type: String,
        }
    },
    data() {
        return {
            approved: null,
            loading: true,
            book: {},
            authors: {},
            genres: {},
            reviews: {},
            averageRating: {},
            ratersCount: {},
            userRating: {},
            user: {},
            authorized: true
        }
    },
    created() {
        this.getUser();
        this.loadBook();
    },
    methods: {
        loadBook(page = null) {
            axios.get(this.bookLoadRoute, {
                params:{
                    page: page
                }
            }).then((response) => {
                let data = response.data;
                this.book = data.book;
                this.authors = data.authors;
                this.genres = data.genres;
                this.reviews = data.reviews;
                this.averageRating = data.averageRating;
                this.ratersCount = data.ratersCount;
                this.userRating = data.userRating;
                this.loading = false;
            }).catch((error) => {
            });
        },
        getUser() {
            axios.get(this.userRoute, {}).then((response) => {
                this.user = response.data;
            }).catch((error) => {
                this.authorized = false;
            })
        },
        approveBook() {
            axios.post(this.bookApproveRoute, {
                _method: 'put'
            }).then((response) => {
                if (response.status === 204) {
                    this.approved = true;
                }
            }).catch((error) => {
                if (error.status === 422) {
                    this.approved = false;
                }
            });
        },
        roundCurrency(num) {
            return new Intl.NumberFormat('lt-lT',
                {style: 'currency', currency: 'EUR'}
            ).format(num);
        },
    }
}
</script>
