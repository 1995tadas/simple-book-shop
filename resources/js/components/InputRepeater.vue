<template>
    <div class="w-full m-auto">
        <template v-for="item in count">
            <input class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300
                          focus:ring focus:ring-indigo-200 focus:ring-opacity-50
                          block mt-1 w-full"
                   @blur="newInput(item)"
                   :type="type" :id="id" :name="name + '[' + item + ']'"
                   v-model="selected[item - 1]" :required="item === 1">
        </template>
    </div>
</template>

<script>
export default {
    props: {
        value: {
            type: Object
        },
        id: {
            type: String,
            required: true
        },
        type: {
            type: String,
            default: "text"
        },
        name: {
            type: String,
            required: true
        }
    },
    created() {
        if (this.value) {
            const valueArray = Object.values(this.value);
            this.count = valueArray.length;
            if (this.count < 3) {
                this.count++
            }

            this.selected = valueArray;
        }
    },
    data() {
        return {
            selected: [],
            count: 1,
        }
    },
    methods: {
        newInput(item) {
            const selectedLength = this.selected.length;
            for (let i = 0; i <= selectedLength; i++) {
                if (this.selected[i] === "") {
                    if (this.count > 1) {
                        this.selected.splice(i, 1);
                        this.count--;
                    }

                    return;
                }
            }

            if (item === this.count && this.count < 3 && this.selected.length > 0) {
                this.count++
            }
        }
    }
}
</script>
