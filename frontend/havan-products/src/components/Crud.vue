<template>
<div style="margin: 0 auto; width: 80%">
    
   <div>
       <Toolbar class="p-mb-4">
        <template #left>
            <Button label="Novo" icon="pi pi-plus" class="p-button-success p-mr-2" @click="openNew" />
            <Button label="Excluir" icon="pi pi-trash" class="p-button-danger" @click="confirmDeleteSelected" :disabled="!selectedProducts || !selectedProducts.length" />
        </template>
    </Toolbar>

<DataTable ref="dt" :value="products" :selection.sync="selectedProducts" dataKey="id"
    :paginator="true" :rows="10" :filters="filters"
    paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown" :rowsPerPageOptions="[5,10,25]"
    currentPageReportTemplate="Mostrando {first} de {last} até {totalRecords} produtos">
    <template #header>
        <div class="table-header">
            <h5 class="p-m-0">Gerenciar Produto</h5>
            <span class="p-input-icon-left">
                <i class="pi pi-search" />
                <InputText v-model="filters['global']" placeholder="Nome do produto..." />
            </span>
        </div>
    </template>

    <Column selectionMode="multiple" headerStyle="width: 3rem"></Column>
    <Column field="code" header="Codigo" sortable></Column>
    <Column field="name" header="Nome" sortable></Column>
    <Column field="price" header="Preço" sortable>
            <template #body="products">
                {{formatCurrency(products.data.price)}}
            </template>
    </Column>
        <Column field="category" header="Categoria" sortable></Column>
        <Column field="status" header="Status" sortable></Column>
    
        <Column>
            <template #body="slotProps">
                <Button icon="pi pi-pencil" class="p-button-rounded p-button-success p-mr-2" @click="editProduct(slotProps.data)" />
                <Button icon="pi pi-trash" class="p-button-rounded p-button-warning" @click="confirmDeleteProduct(slotProps.data)" />
            </template>
        </Column>
    </DataTable>
   </div>

   <Dialog :visible.sync="productDialog" :style="{width: '450px'}" header="Detalhes do Produto" :modal="true" class="p-fluid">
        <div class="p-field">
            <label for="code">Código</label>
                <InputText id="code" v-model.trim="product.code" required="true" autofocus :class="{'p-invalid': submitted && !product.name}" />
            <small class="p-invalid" v-if="submitted && !product.code">Code is required.</small>
        </div>
        <div class="p-field">
            <label for="name">Name</label>
                <InputText id="name" v-model.trim="product.name" required="true" autofocus :class="{'p-invalid': submitted && !product.name}" />
            <small class="p-invalid" v-if="submitted && !product.name">Name is required.</small>
        </div>
        <div class="p-formgrid p-grid">
            <div class="p-field p-col">
                <label for="price">Preço</label>
                <InputNumber id="price" v-model="product.price" mode="currency" currency="USD" locale="en-US"/>
            </div>
        </div>
        <div class="p-field">
            <label class="p-mb-3">Categoria</label>
            <div class="p-formgrid p-grid">
                <div class="p-field-radiobutton p-col-6">
                    <RadioButton id="category1" name="category" value="categoria 1" v-model="product.category"/>
                    <label for="category1">Categoria 1</label>
                </div>
                <div class="p-field-radiobutton p-col-6">
                    <RadioButton id="category2" name="category" value="categoria 2" v-model="product.category"/>
                    <label for="category2">Categoria 2</label>
                </div>
                <div class="p-field-radiobutton p-col-6">
                    <RadioButton id="category3" name="category" value="categoria 3" v-model="product.category"/>
                    <label for="category3">Categoria 3</label>
                </div>
                <div class="p-field-radiobutton p-col-6">
                    <RadioButton id="category4" name="category" value="categoria 4" v-model="product.category"/>
                    <label for="category4">Categoria 4</label>
                </div>
            </div>
        </div>
        <div class="p-field">
            <label class="p-mb3">Status</label>
            <div class="p-formgrid p-grid">
                <div class="p-field-radiobutton p-col-6">
                    <RadioButton id="emestoque" name="emestoque" value="em estoque" v-model="product.status"/>
                    <label for="emestoque">Em Estoque</label>
                </div>
                <div class="p-field-radiobutton p-col-6">
                    <RadioButton id="semestoque" name="semestoque" value="sem estoque" v-model="product.status"/>
                    <label for="emestoque">Sem Estoque</label>
                </div>
            </div>
        </div>
    <template #footer>
        <Button label="Cancel" icon="pi pi-times" class="p-button-text" @click="hideDialog"/>
        <Button label="Save" icon="pi pi-check" class="p-button-text" @click="save" />
    </template>
   </Dialog>
    
    <Toast position="top-left" />
    
    <Dialog :visible.sync="deleteProductDialog" :style="{width: '450px'}" header="Detalhes do Produto" :modal="true" class="p-fluid">
        <div class="confirmation-content">
            <i class="pi pi-exclamation-triangle p-mr-3" style="font-size: 2rem"/>
            <span v-if="product">
                Tem certeza que deseja excluir <b> {{product.name}}</b>?
            </span>
        </div>
        <template #footer>
            <Button label="Não" icon="pi pi-times" class="p-button-text" @click="deleteProductDialog = false"/>
            <Button label="Sim" icon="pi pi-check" class="p-button-text" @click="deleteProduct" />
        </template>
    </Dialog>


</div>




            
    
  
</template>

<script>
import ProductService from '../services/ProductService'
//import axios from 'axios'
export default {
    name: 'Crud',
    data() {
        return {
            products: null,
            product: {
                id: null,
                name: null,
                price: null,
                code: null,
                category: null,
                status: null,
            },
            productDialog: false,
            deleteProductDialog: false,
            deleteProductsDialog: false,
            selectedProducts: null,
            filters: {},
            submited: false,
        }
    },
    productService : null,
    created() {
        this.productService = new ProductService();
    },
    mounted() {
        this.productService.getAll().then(data => { 
        this.products = data.data});
    },
    methods: {

        formatCurrency(value) {
            return value.toLocaleString('en-US', {style: 'currency', currency: 'USD'});
        },
        openNew() {
            this.product = {},
            this.submited = false;
            this.productDialog = true;
            console.log('open new')
        },
        hideDialog() {
            this.productDialog = false;
            this.submitted = false;
        },
        save() {
            this.productService.saveProduct(this.product,this)
            //this.$toast.add({severity:'success', summary: 'Successful', detail: 'Produto Criado', life: 3000});
        },
        edit(product) {
            this.product = {...product}
            this.productDialog = true
        },
        confirmDeleteProduct(product) {
            this.product = product
            this.deleteProductDialog = true
        },
        deleteProduct() {
            this.productService.deleteProduct(this.product)
            this.products = this.products.filter(val => val.id !== this.product.id);
            this.deleteProductDialog = false;
            this.product = {};
        }

    }
}
</script>

<style scoped>
</style>