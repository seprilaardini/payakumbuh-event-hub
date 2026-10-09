<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MasyarakatController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\UlasanController;


/*
|--------------------------------------------------------------------------
| BERANDA
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route(
        'masyarakat.beranda'
    );
})->name('home');


Route::get(
    '/beranda',
    [MasyarakatController::class, 'beranda']
)->name('masyarakat.beranda');


/*
|--------------------------------------------------------------------------
| DAFTAR EVENT
|--------------------------------------------------------------------------
*/

Route::get(
    '/daftar-event',
    [EventController::class, 'index']
)->name('masyarakat.event');


Route::get(
    '/event',
    function () {
        return redirect()->route(
            'masyarakat.event'
        );
    }
)->name('masyarakat.event.redirect');


/*
|--------------------------------------------------------------------------
| DETAIL EVENT
|--------------------------------------------------------------------------
*/

Route::get(
    '/detail-event/{id}',
    [EventController::class, 'detail']
)->name('masyarakat.detail');


Route::get(
    '/event/{id}',
    [EventController::class, 'detail']
)->name('masyarakat.detail.event');


/*
|--------------------------------------------------------------------------
| REGISTRASI
|--------------------------------------------------------------------------
*/

Route::get(
    '/registrasi/{id}',
    [PendaftaranController::class, 'create']
)->name('masyarakat.registrasi.create');


Route::post(
    '/registrasi/simpan-form',
    [PendaftaranController::class, 'simpanForm']
)->name('masyarakat.registrasi.simpanForm');


Route::get(
    '/konfirmasi-pendaftaran',
    [PendaftaranController::class, 'konfirmasi']
)->name('masyarakat.registrasi.konfirmasi');


Route::post(
    '/konfirmasi-pendaftaran/simpan',
    [PendaftaranController::class, 'simpanPendaftaran']
)->name('masyarakat.registrasi.simpanPendaftaran');


Route::get(
    '/registrasi-berhasil/{id}',
    [PendaftaranController::class, 'berhasil']
)->name('masyarakat.registrasi.berhasil');


Route::get(
    '/kode-pendaftaran/{id}',
    [PendaftaranController::class, 'kode']
)->name('masyarakat.registrasi.kode');


/*
|--------------------------------------------------------------------------
| PEMBAYARAN
|--------------------------------------------------------------------------
*/

Route::get(
    '/pembayaran/{id}',
    [PembayaranController::class, 'create']
)->name('masyarakat.pembayaran.create');


Route::post(
    '/pembayaran/{id}',
    [PembayaranController::class, 'proses']
)->name('masyarakat.pembayaran.proses');


/*
|--------------------------------------------------------------------------
| CEK PENDAFTARAN
|--------------------------------------------------------------------------
*/

Route::get(
    '/cek-pendaftaran',
    [PendaftaranController::class, 'cek']
)->name('masyarakat.cek');


Route::post(
    '/cek-pendaftaran',
    [PendaftaranController::class, 'hasilCek']
)->name('masyarakat.cek.hasil');


/*
|--------------------------------------------------------------------------
| DOKUMENTASI
|--------------------------------------------------------------------------
*/

Route::get(
    '/dokumentasi',
    [MasyarakatController::class, 'dokumentasi']
)->name('masyarakat.dokumentasi');


/*
|--------------------------------------------------------------------------
| ULASAN
|--------------------------------------------------------------------------
|
| Halaman ulasan selalu berdasarkan event.
|
| Contoh:
| /ulasan/1
| /ulasan/2
|
*/


/*
|--------------------------------------------------------------------------
| REDIRECT UNTUK URL LAMA /ulasan
|--------------------------------------------------------------------------
|
| Kalau masih ada link lama yang membuka /ulasan,
| jangan sampai muncul error 405.
|
*/

Route::get(
    '/ulasan',
    function () {
        return redirect()->route(
            'masyarakat.event'
        );
    }
)->name('masyarakat.ulasan.lama');


/*
|--------------------------------------------------------------------------
| HALAMAN ULASAN
|--------------------------------------------------------------------------
*/

Route::get(
    '/ulasan/{id}',
    [UlasanController::class, 'index']
)->name('masyarakat.ulasan');


/*
|--------------------------------------------------------------------------
| SIMPAN ULASAN
|--------------------------------------------------------------------------
*/

Route::post(
    '/ulasan',
    [UlasanController::class, 'store']
)->name('masyarakat.ulasan.simpan');