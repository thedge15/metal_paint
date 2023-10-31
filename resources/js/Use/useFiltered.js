import {computed} from "vue";

export function useFiltered(materials, selectedMaterial, selectedElement, selectedProject, selectedPaint, selectedColor)
{
    return computed(() => {

        let filterArray = selectedMaterial.value === 'Наименование' ? materials :
            materials.filter(item => item.metal.title + ' ' + item.characteristic.title === selectedMaterial.value);

        filterArray = selectedElement.value === 'Конструктивный элемент' ? filterArray :
            filterArray.filter(item => item.element.title === selectedElement.value);

        filterArray = selectedProject.value === 'РД' ? filterArray :
            filterArray.filter(item => item.project.title === selectedProject.value);

        if (selectedPaint.value !== "Краска" && selectedColor.value === "Цвет") {
            filterArray = filterArray.filter(item => item.paint === selectedPaint.value);
        }
        if (selectedPaint.value === "Краска" && selectedColor.value !== "Цвет") {
            filterArray = filterArray.filter(item => item.paint_color === selectedColor.value);
        }
        if (selectedPaint.value !== "Краска" && selectedColor.value !== "Цвет") {
            filterArray = filterArray.filter(item => item.paint === selectedPaint.value).filter(item => item.paint_color === selectedColor.value);
        }

        return filterArray
    })
}
