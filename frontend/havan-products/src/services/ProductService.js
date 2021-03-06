import axios from 'axios';


export default class ProductService {
    
    url = 'http://127.0.0.1:8000/api/v1';

    getAll() {
        return axios.get(this.url + '/products')
    }

    saveProduct(product,ctx) {
        axios.post(this.url + '/products', {
                name: product.name,
                price: product.price,
                code: product.code,
                category: product.category,
                status: product.status,
            }).then( (resp) => {
                if (resp.status == 201) {
                    ctx.$toast.add({severity:'success', summary: 'Successful', detail: 'Produto Criado', life: 3000});
                } else {
                    ctx.$toast.add({severity:'error', summary: 'Error', detail: 'Error!!', life: 3000});
                }
            }).catch(error => {
                console.log(error)})
    }
    deleteProduct(product,ctx) {
        axios.delete(this.url + '/products/' + product.id).then( (resp) => {
            if ( resp.status == 200 ) {
                ctx.$toast.add({severity:'success', summary: 'Successful', detail: 'Produto Deletado com Sucesso!', life: 3000});
            } else {
                ctx.$toast.add({severity:'error', summary: 'Error', detail: 'Error!!', life: 3000});
            }
        })
    }
    editProduct(product,ctx) {
        axios.patch(this.url + '/products/' + product.id, {
                    name: product.name,
                    price: product.price,
                    code: product.code,
                    category: product.category,
                    status: product.status,
            }).then( (resp) => {
                if (resp.status == 201) {
                    ctx.$toast.add({severity:'success', summary: 'Successful', detail: 'Produto Editado!', life: 3000});
                } else {
                    ctx.$toast.add({severity:'error', summary: 'Error', detail: 'Error!!', life: 3000});
                }
            }).catch(error => {
                console.log(error)})
    }
}

