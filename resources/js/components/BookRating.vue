s
<template>
    <div class="text-center my-2">
        <ul class="whitespace-nowrap">
            <li class="inline" v-for="star in 5" @mouseover="currentStar = star" @mouseleave="currentStar = 0">
                <a href="" :style="[!storeRoute ? {'cursor':'default'} : '']" @click.prevent="store(star)"
                   class="text-black text-2xl"
                   :class="[{'text-red-400': currentStar >= star && storeRoute}, {'text-blue-400': rated >= star}]">
                    <i class="far fa-star"></i>
                </a>
            </li>
        </ul>
        <span class="block bg-gray-200 text-3xl text-blue-900">
            {{ round(newAverage !== null ? newAverage : average) }}<span class="text-sm">
            /{{ round(newRatersCount !== null ? newRatersCount : ratersCount) }}</span>
        </span>
    </div>
</template>

<script>
export default {
    props: {
        storeRoute: {
            type: String,
        },
        destroyRoute: {
            type: String,
        },
        average: {
            type: Number,
            required: true
        },
        ratersCount: {
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
            rated: 0,
            newAverage: null,
            newRatersCount: null
        }
    },
    created() {
        if (this.userRating) {
            this.rated = this.userRating;
        }
    },
    methods: {
        store(star) {
            if (this.storeRoute) {
                if (this.rated === star) {
                    this.destroy();
                    return;
                }

                axios.post(this.storeRoute, {
                    rate: star,
                }).then((response) => {
                    this.rated = star;
                    this.resetRates();
                    this.addAverage()
                }).catch((error) => {
                });
            }
        },
        destroy() {
            axios.delete(this.destroyRoute).then((response) => {
                this.rated = 0;
                this.resetRates();
            }).catch((error) => {
            });
        },
        addAverage() {
            const currentAverage = this.newAverage !== null ? this.newAverage : this.average
            const currentRatersCount = this.newRatersCount !== null ? this.newRatersCount : this.ratersCount
            this.newRatersCount = currentRatersCount + 1;
            this.newAverage = (currentAverage * currentRatersCount + this.rated) / this.newRatersCount;
        },
        removeUsersVote() {
            if (this.ratersCount <= 1) {
                this.newRatersCount = 0;
                this.newAverage = 0;
            } else {
                this.newRatersCount = this.ratersCount - 1;
                this.newAverage = (this.average * this.ratersCount - this.userRating) / this.newRatersCount;
            }
        },
        nullAverage() {
            this.newAverage = null;
            this.newRatersCount = null;
        },
        resetRates() {
            if (this.userRating) {
                this.removeUsersVote();
            } else {
                this.nullAverage()
            }
        },
        round(number) {
            return Math.round((number + Number.EPSILON) * 100) / 100;
        },
    }
}
</script>
