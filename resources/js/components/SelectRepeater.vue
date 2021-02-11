<template>
    <div class="w-full m-auto">
        <template v-for="item in count">
            <select class="rounded-md shadow-sm
                    border-gray-300 focus:border-indigo-300
                    focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    :id="id" :name="name + '[' + item + ']'"
                    v-model="selected[item - 1]"
                    :required="item === 1"
                    @change="newSelect(item)">
                <option :value="null" selected="selected" :disabled="item === 1"></option>
                <option v-for="option in options" :value="option.value"
                        :disabled = "selected.includes(option.value) && selected[item - 1] !== option.value">
                    {{ option.option }}
                </option>
            </select>
        </template>
    </div>
</template>

<script>
export default {
    props: {
        values:{
            type: [Object, Array],
        },
        options: {
            type: Array,
            required: true
        },
        id: {
            type: String,
            required: true
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
    created() {
        if (this.values) {
            let valueArray = this.values;
            if(typeof this.values === 'object'){
                valueArray = Object.values(this.values);
            }

            this.count = valueArray.length;
            if (this.count < 6 && this.count < this.options.length) {
                this.count++
            }

            this.selected = valueArray.map(Number);
        }
    },
    methods: {
        newSelect(item) {
            const selectedLength = this.selected.length;
            for (let i = 0; i <= selectedLength; i++) {
                if (this.selected[i] === null && this.count > 1) {
                    this.selected.splice(i, 1);
                    this.count--;
                    return;
                }
            }

            if (item === this.count && this.count < 6 && this.count < this.options.length) {
                this.count++
            }
        }
    }
}
</script>
