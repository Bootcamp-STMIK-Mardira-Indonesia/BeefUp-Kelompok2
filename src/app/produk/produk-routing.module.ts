import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { FormProdukComponent } from './form-produk/form-produk.component';
import { ListProdukComponent } from './list-produk/list-produk.component';


const routes: Routes = [
  {
    path: '',
    component : ListProdukComponent
  },
  {
    path: 'tambah',
    component : FormProdukComponent
  },
  {
    path: 'sunting/:id',
    component : FormProdukComponent
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class ProdukRoutingModule { }
