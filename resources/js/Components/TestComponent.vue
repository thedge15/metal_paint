<template>
    <div>
        <div class="control">
            <div class="py-2">
                <select v-model="selectedPaint" class="bg-gray-50 border border-gray-600
                            text-gray-900 text-sm italic text-center rounded-lg focus:ring-blue-500 focus:border-blue-500
                            block w-48 h-8 text-xs">
                    <option selected>{{ selectedPaint }}</option>
                    <option v-if="selectedPaint !== 'Краска'">Краска</option>
                    <option v-for="paint in paints">{{ paint.title }}</option>
                </select>
            </div>
            <p v-if="selPaint">Значение <b>selPaint</b>, отображаемое в "child-component": <b>{{ selPaint }}</b></p>
            <div class="py-2">
                <select v-model="selectedColor" class="bg-gray-50 border border-gray-600
                            text-gray-900 text-sm italic text-center rounded-lg focus:ring-blue-500 focus:border-blue-500
                            block w-32 h-8 text-xs">
                    <option selected>{{ selectedColor }}</option>
                    <option v-if="selectedColor !== 'Цвет'">Цвет</option>
                    <option :class="[value]" v-for="(value, color) in colors">{{ color }}</option>
                </select>
            </div>
            <p v-if="selColor">Значение <b>selColor</b>, отображаемое в "child-component": <b>{{ selColor }}</b></p>
        </div>
    </div>
    `,
</template>

<script>

export default {

    props: [
        'paints'
    ],


    data() {
        return {
            selectedColor: "Цвет",
            selectedPaint: "Краска",

            colors: {
                'RAL 7004': 'bg-gray-400',
                'RAL 1021': 'bg-yellow-500',
                'RAL 5015': 'bg-sky-400',
                'RAL 8002': 'bg-amber-800',
            },
        }
    },

    computed: {
        selPaint() {
            return this.selectedPaint
        },

        selColor() {
            return this.selectedColor
        }
    },

    watch: {
        selPaint() {
            this.$emit('filterPaint', this.selectedPaint)
        },

        selColor() {
            this.$emit('filterColor', this.selectedColor)
        }
    }
}
</script>
