<template>
    <ul>
        <li class="inline" v-for="star in 5" @mouseover="currentStar = star" @mouseleave="currentStar = 0">
            <a href="" @click.prevent="store(star)" class="text-black hover:text-red-400"
               :class="{'text-red-400': currentStar >= star,'text-blue-400': rated === star}">
                <i class="far fa-star"></i>
            </a>
        </li>
    </ul>
</template>

<script>
export default {
    props: {
        storeRoute: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            currentStar: 0,
            rated: 0
        }
    },
    methods: {
        store(star) {
            if (this.rated === star) {
                return;
            }

            axios.post(this.storeRoute, {
                rate: star,
            }).then((response) => {
                this.rated = star;
            }).catch((error) => {
                console.log(error);
            });
        }
    }
}
</script>
