import { Component, OnInit } from '@angular/core';
import { ProdukModel } from '../produk.model';
import { ProdukService } from '../produk.service';

@Component({
  selector: 'app-list-produk',
  templateUrl: './list-produk.component.html',
  styleUrls: ['./list-produk.component.css']
})
export class ListProdukComponent implements OnInit {

  listProduk : ProdukModel[]

  constructor(
    private _ProdukService : ProdukService
  ) { }

  ngOnInit(): void {
    this.getListProduk()
  }


  getListProduk() {
    this._ProdukService.list().subscribe(response=>{
      this.listProduk = response ["produk"]
      // this.listProduk = response  
      console.log(this.listProduk)
    })
  }

  deleteProduk(idProduk : number){
    this._ProdukService.deleteProduk(idProduk).subscribe(response => {
      if(response.status == 200){
      alert("Berhasil Menghapus Data")
      location.reload()
      }else{
        alert("Gagal Menghapus Data")
      }
    })
  }

}
