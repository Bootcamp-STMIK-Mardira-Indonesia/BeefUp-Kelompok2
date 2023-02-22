import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { NgbModule } from '@ng-bootstrap/ng-bootstrap';
import { NavbarComponent } from './navbar/navbar.component';
import { ProfileComponent } from './profile/profile.component';
import { HttpClientModule } from '@angular/common/http';
import { HalamanUtamaComponent } from './halaman-utama/halaman-utama.component';
import { LoginComponent } from './login/login.component';
import { PendaftaranComponent } from './pendaftaran/pendaftaran.component';
import { BerandaComponent } from './beranda/beranda.component';
import { MateriBelajarComponent } from './materi-belajar/materi-belajar.component';
import { TampilanAwalComponent } from './tampilan-awal/tampilan-awal.component';
import { LatihanSoalComponent } from './latihan-soal/latihan-soal.component';
import { SimpanMateriComponent } from './simpan-materi/simpan-materi.component';
import { UbahMateriComponent } from './ubah-materi/ubah-materi.component';
import { TambahSoalComponent } from './tambah-soal/tambah-soal.component';
import { UbahSoalComponent } from './ubah-soal/ubah-soal.component';
import { TestimoniAdminComponent } from './testimoni-admin/testimoni-admin.component';
import { TentangKamiComponent } from './tentang-kami/tentang-kami.component';
import { TestimoniComponent } from './testimoni/testimoni.component';
import { JudulMateriComponent } from './judul-materi/judul-materi.component';
import { JudulSoalComponent } from './judul-soal/judul-soal.component';
import { LatihanSoalSelesaiComponent } from './latihan-soal-selesai/latihan-soal-selesai.component';
import { MateriBelajarAdminComponent } from './materi-belajar-admin/materi-belajar-admin.component';
import { JudulMateriAdminComponent } from './judul-materi-admin/judul-materi-admin.component';
import { LatihanSoalAdminComponent } from './latihan-soal-admin/latihan-soal-admin.component';
import { JudulSoalAdminComponent } from './judul-soal-admin/judul-soal-admin.component';

@NgModule({
  declarations: [
    AppComponent,
    NavbarComponent,
    ProfileComponent,
    HalamanUtamaComponent,
    LoginComponent,
    PendaftaranComponent,
    BerandaComponent,
    MateriBelajarComponent,
    TampilanAwalComponent,
    LatihanSoalComponent,
    SimpanMateriComponent,
    UbahMateriComponent,
    TambahSoalComponent,
    UbahSoalComponent,
    TestimoniAdminComponent,
    TentangKamiComponent,
    TestimoniComponent,
    JudulMateriComponent,
    JudulSoalComponent,
    LatihanSoalSelesaiComponent,
    MateriBelajarAdminComponent,
    JudulMateriAdminComponent,
    LatihanSoalAdminComponent,
    JudulSoalAdminComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    NgbModule,
    HttpClientModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
