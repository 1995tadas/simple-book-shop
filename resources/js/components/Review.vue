<template>
    <div class="w-full">
        <label for="review">{{ translation.write }}</label>
        <span v-show="saved" class="block text-sm  mb-1 text-green-600">
            {{ translation.created }}
        </span>
        <textarea class="w-full h-full" name="review" id="review"
                  v-model="review">
        </textarea>
        <ul v-if="Object.keys(errors).length" class="text-sm mb-1 text-red-600">
            <template v-for="error in errors">
                <li v-for="single in error">{{ single }}</li>
            </template>
        </ul>
        <button class="inline-flex items-center px-4 py-2 bg-gray-800 border
                    border-transparent rounded-md font-semibold text-xs text-white uppercase
                    tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none
                    focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25
                    transition ease-in-out duration-150"
                @click.prevent="store">
            {{ translation.send }}
        </button>
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
            required: true
        },
        reviewsPerPage: {
            type: Number,
            required: true
        },
        page: {
            type: Number,
            required: true
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
                    this.updateDom(response.data);
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
        updateDom(response) {
            this.saved = true;
            this.oldReview = this.review;
            this.review = ''
            this.addReviewToDom(response.content, response.user, response.created_at);
        },
        addReviewToDom(review, userName, createdAt) {
            let reviewsEl = document.getElementById('reviews');
            if (typeof (reviewsEl) !== 'undefined' && reviewsEl !== null && this.page === 1) {
                if (reviewsEl.children.length >= this.reviewsPerPage + 3) {
                    reviewsEl.removeChild(reviewsEl.children[this.reviewsPerPage]);
                }

                const contentText = document.createTextNode(review);
                const userText = document.createTextNode(userName);
                const createdAtText = document.createTextNode(createdAt);

                let userContainerEl = document.createElement('div');
                let contentEl = document.createElement('div')
                let createdAtContainerEl = document.createElement('div');
                let createdAtEl = document.createElement('span');
                let userEl = document.createElement('span');
                let newReviewEl = document.createElement('div')

                userContainerEl.classList.add('w-100', 'md:w-60', 'flex-left', 'md:text-right');
                contentEl.classList.add('flex-1', 'mt-1', 'md:mt-0', 'break-all');
                createdAtContainerEl.classList.add('text-xs', 'm-0', 'md:m-1', 'mb-3');
                createdAtEl.classList.add('bg-blue-100', 'p-1', 'rounded');
                userEl.classList.add('m-0', 'md:m-1', 'bg-blue-100', 'p-1', 'rounded');
                newReviewEl.classList.add('flex', 'justify-between', 'flex-col', 'md:flex-row', 'py-3', 'w-100');

                createdAtEl.appendChild(createdAtText);
                userEl.appendChild(userText);
                contentEl.appendChild(contentText);
                createdAtContainerEl.appendChild(createdAtEl);
                userContainerEl.appendChild(createdAtContainerEl)
                userContainerEl.appendChild(userEl)
                newReviewEl.appendChild(userContainerEl);
                newReviewEl.appendChild(contentEl);

                reviewsEl.insertBefore(newReviewEl, reviewsEl.children[1]);
            }
        },
    }
}
</script>
