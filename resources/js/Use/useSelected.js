import {computed} from "vue";

export function useSelected(materials, checkedMaterials)
{
    const allSelectedMaterials = computed(() => {
        return materials.filter(material => checkedMaterials.value.includes(material.id));
    })

    const selectedMaterialWeight = computed(() => {
        const materialWeight = allSelectedMaterials.value.map((material) => material.weight)
        return materialWeight.reduce(function (a, b) {
            return Number(a) + Number(b);
        }, 0);
    })

    const selectedMaterialPaint = computed(() => {
        const materialPaint = allSelectedMaterials.value.map((material) => material.paint_quantity)
        return materialPaint.reduce(function (a, b) {
            return Number(a) + Number(b);
        }, 0);
    })

    return { selectedMaterialWeight, selectedMaterialPaint }
}
