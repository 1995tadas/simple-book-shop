<template>
    <div class="text-center my-2">
        <ul class="whitespace-nowrap">
            <li class="inline" v-for="star in 5" @mouseover="currentStar = star" @mouseleave="currentStar = 0">
                <a href="" @click.prevent="store(star)" class="text-black text-2xl hover:text-red-400"
                   :class="{'text-red-400': currentStar >= star,'text-blue-400': rated >= star}">
                    <i class="far fa-star"></i>
                </a>
            </li>
        </ul>
        <span class="block bg-gray-200 text-3xl text-blue-900">{{ ratings }}</span>
    </div>
</template>

<script>
export default {
    props: {
        storeRoute: {
            type: String,
            required: true
        },
        destroyRoute: {
            type: String,
            required: true
        },
        ratings: {
            type: Number,
            required: true
        },
        userRating: {
            type: Number,
        },
    },
    data() {
        return {
            currentStar: 0,
            rated: 0
        }
    },
    created() {
        if (this.userRating) {
            this.rated = this.userRating;
        }
    },
    methods: {
        store(star) {
            if (this.rated === star) {
                this.destroy(star);
                return;
            }

            axios.post(this.storeRoute, {
                rate: star,
            }).then((response) => {
                this.rated = star;
            }).catch((error) => {
                console.log(error);
            });
        },
        destroy(star) {
            axios.delete(this.destroyRoute).then((response) => {
                this.rated = 0;
            }).catch((error) => {
                console.log(error);
            });
        }
    }
}
</script>
