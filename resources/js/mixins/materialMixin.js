export default {
    data() {
        return {
            checkedMaterials: [],
            hideDelete: false,
            hideMaterial: false,
            hideUpdate: true,
            delElement: '',
            updId: null,
            updNumb: null,
            updElement: '',
            updTitle: '',
            updWeight: null,
            updPaint: '',
            updPaintColor: '',
            updNumberOfLayers: 'Слои',
            updIsPile: false,
            selectedPaint: "Краска",
            selectedColor: "Цвет",
            layers: [1, 2, 3],
        }
    },

    methods: {
        showUpdate(item) {
            this.hideUpdate = !this.hideUpdate
            this.updProduct = item
            this.updNumb = item.numb
            this.updId = item.id
            this.updElement = item.element
            this.updTitle = item.title
            this.updWeight = item.weight
            this.updPaint = item.paint
            this.updPaintColor = item.paint_color
            this.updNumberOfLayers = item.number_of_layers
            this.updIsPile = Boolean(item.is_pile)
        },

        closeUpdate() {
            this.hideUpdate = !this.hideUpdate
            this.updId = null
            this.updNumb = null
            this.updProduct = ''
            this.updElement = ''
            this.updTitle = ''
            this.updWeight = null
            this.updPaint = ''
            this.updPaintColor = ''
            this.updNumberOfLayers = 'Слои'
            this.updIsPile = false
        },

        updateProduct() {
            this.$inertia.patch(route(`update.material`, this.updProduct.id), {
                id: this.updProduct.id,
                numb: this.updNumb,
                element: this.updElement,
                title: this.updTitle,
                weight: this.updWeight,
                length: this.updProduct.length,
                area: this.updProduct.area,
                paint: this.updPaint,
                paint_color: this.updPaintColor,
                number_of_layers: this.updNumberOfLayers,
                is_pile: this.updIsPile,
            });
            this.closeUpdate()
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

        filterPaint(data) {
            this.selectedPaint = data
        },

        filterColor(data) {
            this.selectedColor = data
        },
    },

    computed: {
        allSelectedMaterials() {
            return this.materials.filter((material) => this.checkedMaterials.includes(material.id))
        },

        selectedMaterialWeight() {
            const materialWeight = this.allSelectedMaterials.map((material) => material.weight)
            return materialWeight.reduce(function (a, b) {
                return Number(a) + Number(b);
            }, 0);
        },

        selectedMaterialPaint() {
            const materialPaint = this.allSelectedMaterials.map((material) => material.paint_quantity)
            return materialPaint.reduce(function (a, b) {
                return Number(a) + Number(b);
            }, 0);
        },

        selectAll: {
            get: function () {
                return this.selectedPaintArray ? this.checkedMaterials.length === this.selectedPaintArray.length : false;
            },
            set: function (value) {
                const selected = [];

                if (value) {
                    this.selectedPaintArray.forEach(function (material) {
                        selected.push(material.id);
                    });
                }

                this.checkedMaterials = selected;
            }
        },

        selectedPaintArray() {
            if (this.selectedPaint === "Краска" && this.selectedColor === "Цвет") {
                return this.materials;
            }

            if (this.selectedPaint !== "Краска" && this.selectedColor === "Цвет") {
                return this.materials.filter(item => item.paint === this.selectedPaint);
            }

            if (this.selectedPaint === "Краска" && this.selectedColor !== "Цвет") {
                return this.materials.filter(item => item.paint_color === this.selectedColor);
            }

            if (this.selectedPaint !== "Краска" && this.selectedColor !== "Цвет") {
                return this.materials.filter(item => item.paint === this.selectedPaint).filter(item => item.paint_color === this.selectedColor);
            }
        }
    }
}
