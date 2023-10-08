import {ref} from "vue";

export function closeStore(hideMaterial) {
    hideMaterial = !hideMaterial
    return hideMaterial;
}
// export default function increment(count) {
//     return count++;
// }
