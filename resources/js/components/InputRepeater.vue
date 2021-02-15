<template>
    <div class="w-full m-auto">
        <template v-for="item in count">
            <input list="auto-complete" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300
                          focus:ring focus:ring-indigo-200 focus:ring-opacity-50
                          block mt-1 w-full"
                   @blur="newInput(item)"
                   @input="autoComplete(item)"
                   :type="type" :id="id + '-' + item" :name="name + '[' + item + ']'"
                   v-model="selected[item - 1]" :required="item === 1">
            <datalist v-if="autoCompleteValues" id="auto-complete">
                <option v-for="value in autoCompleteValues" :value="value"></option>
            </datalist>
        </template>
    </div>
</template>

<script>
export default {
    props: {
        values: {
            type: [Object, Array],
        },
        autoCompleteRoute: {
            type: String
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
    data() {
        return {
            selected: [],
            count: 1,
            autoCompleteValues: []
        }
    },
    created() {
        if (this.values) {
            let valueArray = this.values;
            if (typeof this.values === 'object') {
                valueArray = Object.values(this.values);
            }

            this.count = valueArray.length;
            if (this.count < 3) {
                this.count++
            }

            this.selected = valueArray;
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
        },
        autoComplete(item) {
            if (this.autoCompleteRoute) {
                axios.get(this.autoCompleteRoute, {
                    params: {
                        search: this.selected[item - 1],
                    }
                }).then((response) => {
                    this.autoCompleteValues = response.data;
                }).catch((error) => {

                });
            }
        }
    }
}
</script>
