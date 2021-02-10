<template>
    <div>
        <template v-for="(input, label) in inputs">
            <div class="mt-4">
                <label class="block font-medium text-sm text-gray-700" :for="input">
                    {{ label }}
                </label>
                <input :id="input" class="rounded-md shadow-sm border-gray-300
                focus:border-indigo-300 focus:ring focus:ring-indigo-200
                focus:ring-opacity-50 block mt-1 w-full"
                       :type="show ? 'text' : 'password'"
                       :name="input"
                       required autocomplete="new-password"
                >
            </div>
        </template>
        <div class="mt-4">
            <label class="inline font-medium text-sm text-gray-700 mr-1" for="show">
                {{ checkboxLabel }}
            </label>
            <input v-model="show" type="checkbox" id="show">
        </div>
    </div>
</template>

<script>
export default {
    props: {
        inputs: {
            type: Object,
            required: true
        },
        checkboxLabel: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            show: false
        }
    }
}
</script>
