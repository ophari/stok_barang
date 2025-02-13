import axios from 'axios';

export function increaseStock(productId) {
    axios.post(`/products/${productId}/increase-stock`, {}, {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    }).then(response => {
        alert(response.data.message);
        location.reload();
    }).catch(error => {
        console.error('Error:', error);
        alert('Gagal menambah stok');
    });
}
