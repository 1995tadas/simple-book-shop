<template>
    <div id="reviews" class="my-2">
        <div class="flex justify-between py-3 w-100">
            <div class="w-60 hidden md:block md:invisible"><span class="inline">|</span></div>
            <div class="flex-grow">
                <h1 class="w-100 text-3xl border-b-4 border-black">{{ translation.reviews }}</h1>
            </div>
        </div>
        <template v-if="reviews.data.length !== 0">
            <template v-for="review in reviews.data">
                <div class="flex justify-between flex-col md:flex-row py-3 w-100">
                    <div class="w-100 md:w-60 flex-left md:text-right">
                        <div class="text-xs m-0 md:m-1 mb-3">
                            <span class="bg-blue-100 p-1 rounded">{{ review.created_at }}</span>
                        </div>
                        <span class="m-0 md:m-1 bg-blue-100 p-1 rounded"
                              :class="{'text-red-400':review.users.id === user.id}"
                        >{{ review.users.name }}</span>
                    </div>
                    <span class="flex-1 mt-1 md:mt-0 break-all">{{ review.content }}</span>
                </div>
            </template>
        </template>
        <div v-else class="text-right text-xl mb-1">
            {{ translation.nothing }}
        </div>

        <div v-if="reviews.prev_page_url !== null || reviews.next_page_url !== null" class="flex justify-start md:justify-end">
          <a @click.prevent="reviews.current_page !== 1 ? pagination(reviews.current_page - 1) : ''"
             class="p-4 m-1 bg-green-200 text-xl"
             :class="[reviews.current_page === 1 ? 'opacity-20' : 'cursor-pointer hover:border-black border-2']"
          ><</a>
            <span class="p-4 m-1 bg-green-500 text-xl">
                {{ reviews.current_page }}
            </span>
           <a @click.prevent="reviews.next_page_url !== null ? pagination(reviews.current_page + 1) : ''"
           class="p-4 m-1 bg-green-200 text-xl"
              :class="[reviews.next_page_url === null ? 'opacity-20' : 'cursor-pointer hover:border-black border-2']"
           >></a>
        </div>
        <template v-if="Object.keys(user).length">
            <label for="review">{{ translation.write }}</label>
            <span v-show="saved" class="block text-sm  mb-1 text-green-600">
                {{ translation.created }}
            </span>
            <ul v-if="Object.keys(errors).length" class="text-sm mb-1 text-red-600">
                <template v-for="error in errors">
                    <li v-for="single in error">{{ single }}</li>
                </template>
            </ul>
            <textarea class="w-full h-full" name="review" id="review"
                      v-model="review">
            </textarea>
            <button class="inline-flex items-center px-4 py-2 bg-gray-800 border
                        border-transparent rounded-md font-semibold text-xs text-white uppercase
                        tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none
                        focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25
                        transition ease-in-out duration-150"
                    @click.prevent="store">
                {{ translation.send }}
            </button>
        </template>
        <template v-else>
            <div class="text-right mt-1">
                {{ translation.not_logged_first_part }}
                <a class="text-indigo-500 hover:text-indigo-300
                        background-transparent font-bold uppercase
                        py-1 text-sm outline-none focus:outline-none"
                   :href="loginRoute">
                    {{ translation.not_logged_second_part }}
                </a>
                {{ translation.not_logged_third_part }}
                <a class="text-indigo-500 hover:text-indigo-300
                        background-transparent font-bold uppercase
                        py-1 text-sm outline-none focus:outline-none" :href="registerRoute">
                    {{ translation.not_logged_fourth_part }}
                </a>
            </div>
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
        storeRoute: {
            type: String,
        },
        loginRoute:{
            type: String,
        },
        registerRoute:{
            type: String,
        },
        reviews:{
            type: Object,
            required: true
        },
        user: {
            type: Object,
        }
    },
    data() {
        return {
            review: '',
            oldReview: '',
            saved: false,
            errors: []
        }
    },
    methods: {
        store() {
            this.saved = false
            this.errors = []
            if (this.validate()) {
                axios.post(this.storeRoute, {
                    content: this.review,
                }).then((response) => {
                    this.updateDom();
                }).catch((error) => {
                    this.errors = error.response.data.errors;
                });
            }
        },
        validate() {
            return this.validateLength(255) && this.validateOld()
        },
        validateLength(max) {
            const length = this.review.length
            let valid = false;
            if (length <= 0) {
                this.errors = [[this.translation.empty_validation]]
            } else if (length > max) {
                this.errors = [[this.translation.length_validation + ' ' + max]]
            } else {
                valid = true;
            }

            return valid;
        },
        validateOld() {
            if (this.oldReview === this.review) {
                this.errors = [[this.translation.same]]
                return false;
            }

            return true;
        },
        updateDom() {
            this.saved = true;
            this.oldReview = this.review;
            this.$emit('newReview', this.reviews.current_page)
            this.review = ''
        },
        pagination(page){
            this.$emit('newReview', page)
        }
    }
}
</script>
