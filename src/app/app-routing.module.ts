import { componentFactoryName } from '@angular/compiler';
import { Component, NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { BerandaComponent } from './beranda/beranda.component';
import { HalamanUtamaComponent } from './halaman-utama/halaman-utama.component';
import { JudulMateriAdminComponent } from './judul-materi-admin/judul-materi-admin.component';
import { JudulMateriComponent } from './judul-materi/judul-materi.component';
import { JudulSoalAdminComponent } from './judul-soal-admin/judul-soal-admin.component';
import { JudulSoalComponent } from './judul-soal/judul-soal.component';
import { LatihanSoalAdminComponent } from './latihan-soal-admin/latihan-soal-admin.component';
import { LatihanSoalSelesaiComponent } from './latihan-soal-selesai/latihan-soal-selesai.component';
import { LatihanSoalComponent } from './latihan-soal/latihan-soal.component';
import { LoginComponent } from './login/login.component';
import { MateriBelajarAdminComponent } from './materi-belajar-admin/materi-belajar-admin.component';
import { MateriBelajarComponent } from './materi-belajar/materi-belajar.component';
import { PendaftaranComponent } from './pendaftaran/pendaftaran.component';
import { ProdukModule } from './produk/produk.module';
import { ProfileComponent } from './profile/profile.component';
import { SimpanMateriComponent } from './simpan-materi/simpan-materi.component';
import { TambahSoalComponent } from './tambah-soal/tambah-soal.component';
import { TampilanAwalComponent } from './tampilan-awal/tampilan-awal.component';
import { TentangKamiComponent } from './tentang-kami/tentang-kami.component';
import { TestimoniAdminComponent } from './testimoni-admin/testimoni-admin.component';
import { TestimoniComponent } from './testimoni/testimoni.component';
import { UbahMateriComponent } from './ubah-materi/ubah-materi.component';
import { UbahSoalComponent } from './ubah-soal/ubah-soal.component';


const routes: Routes = [

  {
    path : 'produk',
    loadChildren : () => ProdukModule
  },
  {
    path : 'login',
    component : LoginComponent
  },
  {
    path : 'halaman-utama',
    component : HalamanUtamaComponent
  },
  {
    path : 'pendaftaran',
    component : PendaftaranComponent
  },
  {
    path : '',
    component : TampilanAwalComponent
  },
  {
    path : 'materi-belajar-admin',
    component : MateriBelajarAdminComponent
  },
  {
    path : 'judul-materi-admin',
    component : JudulMateriAdminComponent
  },
  {
    path : 'latihan-soal-admin',
    component : LatihanSoalAdminComponent
  },
  {
    path : 'judul-soal-admin',
    component : JudulSoalAdminComponent
  },
  {
    path : 'profile',
    component : ProfileComponent
  },
  {
    path : 'latihan-soal-selesai',
    component : LatihanSoalSelesaiComponent
  },
  {
    path : 'beranda',
    component : BerandaComponent
  },
  {
    path : 'materi-belajar',
    component : MateriBelajarComponent
  },
  {
    path : 'judul-materi',
    component : JudulMateriComponent
  },
  {
    path : 'judul-soal',
    component : JudulSoalComponent
  },
  {
    path : 'latihan-soal',
    component : LatihanSoalComponent
  },
  {
    path : 'simpan-materi',
    component : SimpanMateriComponent
  },
  {
    path : 'ubah-materi',
    component : UbahMateriComponent
  },
  {
    path : 'tambah-soal',
    component : TambahSoalComponent
  },
  {
    path : 'ubah-soal',
    component : UbahSoalComponent
  },
  {
    path : 'testimoni-admin',
    component : TestimoniAdminComponent
  },
  {
    path : 'tentang-kami',
    component : TentangKamiComponent
  },
  {
    path : 'testimoni',
    component : TestimoniComponent
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
