export class ProdukModel{
    // nanti data nya di kirim dari backendd//
produkId : number
produkNama : string
produkJenis : string
produkBerat :number
produsenId : number
produsenNama : string
produsenKode : string
produsenAlamat : string
}
export class saveProduk{
    produkId : number
    produkNama : string
    produkJenis : string
    produkBerat : number
    produsenId : number
  }
  
  export class ProdusenModel{
    produsenId:number;
    produsenNama:string;
    produsenKode:string;
    produsenAlamat:string;
  }