<template>
    <div class="my-2">
        <div class="grid grid-rows-2 gap-4">
            <div class="col-span-3 row-span-1">
                <div>placeholder</div>
            </div>
            <div class="col-span-2 row-span-1 col-start-2">
                <div class="w-full">
                    <label for="review">{{translation.write}}</label>
                    <textarea class="w-full h-full" name="review" id="review"
                              v-model="review"
                    ></textarea>
                    <ul v-if="Object.keys(errors).length" class="text-sm mb-1 text-red-600">
                        <template v-for="error in errors">
                            <li v-for="single in error">{{ single }}</li>
                        </template>
                    </ul>
                    <span v-if="saved" class="block text-sm  mb-1 text-green-600">
                    {{ translation.created }}
                    </span>
                    <button class="inline-flex items-center px-4 py-2 bg-gray-800 border
                    border-transparent rounded-md font-semibold text-xs text-white uppercase
                    tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none
                    focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25
                    transition ease-in-out duration-150"
                            @click.prevent="store">
                        {{ translation.send }}
                    </button>
                </div>
            </div>
        </div>
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
                    this.saved = true;
                    this.oldReview = this.review;
                    this.review = ''
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
            console.log(length);
            if (length <= 0) {
                this.errors = [[this.translation.empty_validation]]
            } else if (length > max) {
                this.errors = [[this.translation.length_validation + ' ' + max ]]
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
    }
}
</script>
