<script>
import {ref} from "vue";

const hideMaterial = ref(false);
export default function closeStore() {
    hideMaterial.value = !hideMaterial.value

    return hideMaterial
}


</script>
