import ProductList from './components/ProductList.vue'
import ProductView from './components/ProductView.vue'

export const routes = [
{
path: '/products',
name: 'Products',
component: ProductList,
},
{
path: '/products/:id',
name: 'Show Product',
component: ProductView,
hidden: true
},
]
