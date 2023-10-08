export default {
    data() {
        return {
            hideDelete: false,
            hideMaterial: false,
            hideUpdate: true,
            delElement: '',
            updId: null,
            updTitle: '',
            updTonLength: null,
            updTonArea: null,
            updChange: '',
            updConsumption: null,
            showFilter: false,
        }
    },

    methods: {
        showUpdate(item) {
            this.hideUpdate = !this.hideUpdate
            this.updProduct = item
            this.updId = item.id
            this.updTitle = item.title
            this.updTonArea = item.ton_area
            this.updTonLength = item.ton_length
            this.updChange = item.change
            this.updConsumption = item.consumption
        },

        updateProject(updateRoute) {
            this.$inertia.patch(route(`update.${updateRoute}`, this.updId), {
                title: this.updTitle,
                change: this.updChange,
                ton_length: this.updTonLength,
                ton_area: this.updTonArea,
                consumption: this.updConsumption,
            })
            this.closeUpdate()
        },

        closeUpdate() {
            this.hideUpdate = !this.hideUpdate
            this.updId = null
            this.updTitle = ''
            this.updChange = null
            this.updProduct = ''
        },

        closeStore() {
            this.hideMaterial = !this.hideMaterial
        },

        showDelete(item) {
            this.hideDelete = !this.hideDelete
            this.delElement = item
        },

        closeDelete() {
            this.delElement = ''
            this.hideDelete = !this.hideDelete
        },
    },
}
