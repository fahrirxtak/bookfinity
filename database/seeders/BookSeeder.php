<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        Book::insert([
            [
                'title' => 'Belajar Laravel Dasar',
                'author' => 'Fakhri Nugraha',
                'img' => 'img/buku1.png',
                'deskripsi' => 'Panduan lengkap belajar Laravel dari awal.',
                'isi' => 'Isi buku Laravel Dasar sangat cocok untuk pemula...',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Mastering PHP OOP',
                'author' => 'Rizky Pratama',
                'img' => 'img/buku2.png',
                'deskripsi' => 'Buku lengkap tentang Object Oriented Programming di PHP.',
                'isi' => 'OOP di PHP sangat penting untuk pengembangan aplikasi modern...',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Frontend with Tailwind CSS',
                'author' => 'Dewi Anggraini',
                'img' => 'img/buku3.png',
                'deskripsi' => 'Desain modern dengan Tailwind CSS.',
                'isi' => 'Tailwind CSS membuat proses styling jauh lebih efisien...',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Javascript for Beginners',
                'author' => 'Andi Wijaya',
                'img' => 'img/buku4.png',
                'deskripsi' => 'Pelajari dasar-dasar JavaScript dengan mudah.',
                'isi' => 'JavaScript merupakan bahasa wajib untuk pengembangan web...',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Database MySQL Praktis',
                'author' => 'Siti Rahma',
                'img' => 'img/buku5.png',
                'deskripsi' => 'Membuat dan mengelola database dengan MySQL.',
                'isi' => 'Database relasional MySQL banyak digunakan di berbagai sistem...',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
