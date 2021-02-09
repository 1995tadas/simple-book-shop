<template>
    <div class="w-full m-auto">
        <template v-for="item in count">
            <input class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300
                          focus:ring focus:ring-indigo-200 focus:ring-opacity-50
                          block mt-1 w-full"
                   @blur="newInput(item)"
                   :type="type" :id="id" :name="name + '[' + item + ']'"
                   v-model="selected[item]" :required="item === 1">
        </template>
    </div>
</template>

<script>
export default {
    props: {
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
                if (this.selected[i] === "" && this.count > 1) {
                    this.selected.splice(i, 1);
                    console.log(this.selected);
                    this.count--;
                    return;
                }
            }

            if (item === this.count && this.count < 3 && this.selected.length > 1) {
                this.count++
            }
        }
    }
}
</script>
