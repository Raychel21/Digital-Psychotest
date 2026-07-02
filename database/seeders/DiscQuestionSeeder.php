<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DiscQuestion;
use App\Models\DiscItem;

class DiscQuestionSeeder extends Seeder
{
    public function run(): void
    {
        $questions = [
            1 => [
                ['statement' => 'Mudah bergaul, ramah', 'most' => 'S', 'least' => 'S'],
                ['statement' => 'Penuh kepercayaan, Percaya kepada orang lain', 'most' => 'I', 'least' => 'I'],
                ['statement' => 'Petualang, pengambil risiko', 'most' => 'N', 'least' => 'D'],
                ['statement' => 'Toleran, Penuh hormat', 'most' => 'C', 'least' => 'C'],
            ],
            2 => [
                ['statement' => 'Yang penting adalah hasil', 'most' => 'D', 'least' => 'D'],
                ['statement' => 'Melakukan dengan benar, Ketepatan dihitung', 'most' => 'C', 'least' => 'C'],
                ['statement' => 'Buat menjadi menyenangkan', 'most' => 'N', 'least' => 'I'],
                ['statement' => 'Mari melakukan bersama', 'most' => 'N', 'least' => 'S'],
            ],
            3 => [
                ['statement' => 'Pendidikan, Kebudayaan', 'most' => 'N', 'least' => 'C'],
                ['statement' => 'Pencapaian, Penghargaan', 'most' => 'D', 'least' => 'D'],
                ['statement' => 'Keselamatan, Keamanan', 'most' => 'S', 'least' => 'S'],
                ['statement' => 'Sosial, Pertemuan kelompok', 'most' => 'I', 'least' => 'N'],
            ],
            4 => [
                ['statement' => 'Lembut, Pendiam', 'most' => 'C', 'least' => 'N'],
                ['statement' => 'Optimis, Pengkhayal', 'most' => 'D', 'least' => 'D'],
                ['statement' => 'Pusat perhatian, Mudah bersosialisasi', 'most' => 'N', 'least' => 'I'],
                ['statement' => 'Pembuat perdamaian, Membawa ketenangan', 'most' => 'S', 'least' => 'S'],
            ],
            5 => [
                ['statement' => 'Akan melakukan tanpa, Kontrol diri', 'most' => 'N', 'least' => 'C'],
                ['statement' => 'Akan membeli berdasarkan hasrat', 'most' => 'D', 'least' => 'D'],
                ['statement' => 'Akan menunggu, Tidak ada tekanan', 'most' => 'S', 'least' => 'S'],
                ['statement' => 'Akan membelanjakan apa yang saya inginkan', 'most' => 'I', 'least' => 'N'],
            ],
            6 => [
                ['statement' => 'Bertanggung jawab, Pendekatan langsung', 'most' => 'D', 'least' => 'D'],
                ['statement' => 'Mudah bergaul, Antusias', 'most' => 'N', 'least' => 'I'],
                ['statement' => 'Mudah ditebak, Konsisten', 'most' => 'N', 'least' => 'S'],
                ['statement' => 'Waspada, Berhati-hati', 'most' => 'C', 'least' => 'N'],
            ],
            7 => [
                ['statement' => 'Mendorong orang lain', 'most' => 'I', 'least' => 'I'],
                ['statement' => 'Berjuang demi kesempurnaan', 'most' => 'N', 'least' => 'C'],
                ['statement' => 'Menjadi bagian tim', 'most' => 'N', 'least' => 'S'],
                ['statement' => 'Ingin mencapai tujuan', 'most' => 'D', 'least' => 'N'],
            ],
            8 => [
                ['statement' => 'Ramah, Mudah berteman', 'most' => 'S', 'least' => 'N'],
                ['statement' => 'Unik, Bosan dengan rutinitas', 'most' => 'N', 'least' => 'I'],
                ['statement' => 'Aktif merubah hal-hal', 'most' => 'D', 'least' => 'D'],
                ['statement' => 'Menginginkan sesuatu yang pasti', 'most' => 'C', 'least' => 'C'],
            ],
            9 => [
                ['statement' => 'Tidak mudah dikalahkan', 'most' => 'D', 'least' => 'D'],
                ['statement' => 'Akan melakukan sesuai perintah, Mengikuti pimpinan', 'most' => 'S', 'least' => 'N'],
                ['statement' => 'Riang, Ceria', 'most' => 'I', 'least' => 'I'],
                ['statement' => 'Ingin segalanya teratur, Rapi', 'most' => 'N', 'least' => 'C'],
            ],
            10 => [
                ['statement' => 'Pendekatan langsung, Tanpa basa-basi', 'most' => 'D', 'least' => 'D'],
                ['statement' => 'Suka bergaul, Antusias', 'most' => 'I', 'least' => 'I'],
                ['statement' => 'Terukur, Dapat diandalkan', 'most' => 'S', 'least' => 'S'],
                ['statement' => 'Berhati-hati, Teliti', 'most' => 'C', 'least' => 'C'],
            ],
            11 => [
                ['statement' => 'Berani, Pengambil risiko', 'most' => 'D', 'least' => 'D'],
                ['statement' => 'Ekspresif, Banyak bicara', 'most' => 'I', 'least' => 'I'],
                ['statement' => 'Stabil, Sabar', 'most' => 'S', 'least' => 'S'],
                ['statement' => 'Tepat, Detail', 'most' => 'C', 'least' => 'C'],
            ],
            12 => [
                ['statement' => 'Menyukai tantangan, Kompetitif', 'most' => 'D', 'least' => 'D'],
                ['statement' => 'Optimis, Positif', 'most' => 'I', 'least' => 'I'],
                ['statement' => 'Akomodatif, Membantu', 'most' => 'S', 'least' => 'S'],
                ['statement' => 'Logis, Analitis', 'most' => 'C', 'least' => 'C'],
            ],
            13 => [
                ['statement' => 'Hidup, Cerewet', 'most' => 'I', 'least' => 'N'],
                ['statement' => 'Bekerja dengan cepat, Tekun', 'most' => 'D', 'least' => 'D'],
                ['statement' => 'Mencoba mempertahankan keseimbangan', 'most' => 'S', 'least' => 'S'],
                ['statement' => 'Mencoba mengikuti aturan', 'most' => 'N', 'least' => 'C'],
            ],
            14 => [
                ['statement' => 'Menginginkan kemajuan', 'most' => 'D', 'least' => 'D'],
                ['statement' => 'Puas dengan beberapa hal, Mudah puas', 'most' => 'S', 'least' => 'N'],
                ['statement' => 'Menggambarkan perasaan secara terbuka', 'most' => 'I', 'least' => 'N'],
                ['statement' => 'Rendah hati, sederhana', 'most' => 'N', 'least' => 'C'],
            ],
            15 => [
                ['statement' => 'Memikirkan orang lain dahulu', 'most' => 'S', 'least' => 'S'],
                ['statement' => 'Kompetitif, Menyukai tantangan', 'most' => 'N', 'least' => 'I'],
                ['statement' => 'Optimis, Positif', 'most' => 'D', 'least' => 'D'],
                ['statement' => 'Berpikir logis, Sistematis', 'most' => 'C', 'least' => 'C'],
            ],
            16 => [
                ['statement' => 'Mengatur waktu secara efisien', 'most' => 'C', 'least' => 'N'],
                ['statement' => 'Sering terburu-buru, Merasa tertekan', 'most' => 'D', 'least' => 'D'],
                ['statement' => 'Hal-hal sosial merupakan hal yang penting', 'most' => 'I', 'least' => 'I'],
                ['statement' => 'Menyelesaikan apa yang telah dimulai', 'most' => 'S', 'least' => 'S'],
            ],
            17 => [
                ['statement' => 'Tenang, Pendiam', 'most' => 'C', 'least' => 'C'],
                ['statement' => 'Bahagia, Riang', 'most' => 'I', 'least' => 'I'],
                ['statement' => 'Menyenangkan, Baik', 'most' => 'S', 'least' => 'N'],
                ['statement' => 'Tegas, Berani', 'most' => 'D', 'least' => 'D'],
            ],
            18 => [
                ['statement' => 'Menyenangkan orang, Ramah', 'most' => 'S', 'least' => 'S'],
                ['statement' => 'Tertawa keras, hidup', 'most' => 'N', 'least' => 'I'],
                ['statement' => 'Berani, tegas', 'most' => 'D', 'least' => 'D'],
                ['statement' => 'Tenang, Pendiam', 'most' => 'C', 'least' => 'C'],
            ],
            19 => [
                ['statement' => 'Menolak perubahan mendadak', 'most' => 'S', 'least' => 'N'],
                ['statement' => 'Cenderung sering berjanji', 'most' => 'I', 'least' => 'I'],
                ['statement' => 'Menyendiri jika dibawah tekanan', 'most' => 'N', 'least' => 'C'],
                ['statement' => 'Tidak takut berkelahi', 'most' => 'N', 'least' => 'D'],
            ],
            20 => [
                ['statement' => 'Menghabiskan waktu berharga dengan orang lain', 'most' => 'S', 'least' => 'S'],
                ['statement' => 'Merencanakan masa depan, Menyiapkan diri', 'most' => 'C', 'least' => 'N'],
                ['statement' => 'Perjalanan menuju petualangan baru', 'most' => 'I', 'least' => 'I'],
                ['statement' => 'Mendapat penghargaan jika mencapai tujuan', 'most' => 'D', 'least' => 'D'],
            ],
            21 => [
                ['statement' => 'Menginginkan kekuasaan lebih', 'most' => 'N', 'least' => 'D'],
                ['statement' => 'Menginginkan kesempatan baru', 'most' => 'I', 'least' => 'N'],
                ['statement' => 'Menghindari konflik apapun', 'most' => 'S', 'least' => 'S'],
                ['statement' => 'Menginginkan arah yang jelas', 'most' => 'N', 'least' => 'C'],
            ],
            22 => [
                ['statement' => 'Seorang pendukung yang baik', 'most' => 'I', 'least' => 'I'],
                ['statement' => 'Seorang pendengar yang baik', 'most' => 'S', 'least' => 'S'],
                ['statement' => 'Seorang penganalisa yang baik', 'most' => 'C', 'least' => 'C'],
                ['statement' => 'Seorang delegasi yang baik', 'most' => 'D', 'least' => 'D'],
            ],
            23 => [
                ['statement' => 'Peraturan perlu ditolak', 'most' => 'N', 'least' => 'D'],
                ['statement' => 'Peraturan membuat adil', 'most' => 'C', 'least' => 'N'],
                ['statement' => 'Peraturan membuat bosan', 'most' => 'I', 'least' => 'I'],
                ['statement' => 'Peraturan membuat aman', 'most' => 'S', 'least' => 'S'],
            ],
            24 => [
                ['statement' => 'Bisa diandalkan, Bisa digantungkan', 'most' => 'N', 'least' => 'S'],
                ['statement' => 'Kreatif, Unik', 'most' => 'I', 'least' => 'I'],
                ['statement' => 'Berorientasi kepada hasil, Inti', 'most' => 'D', 'least' => 'N'],
                ['statement' => 'Memegang teguh standar tinggi, Akurat', 'most' => 'C', 'least' => 'N'],
            ],
        ];

        foreach ($questions as $nomor => $items) {
            $question = DiscQuestion::create(['nomor' => $nomor]);
            foreach ($items as $item) {
                DiscItem::create([
                    'disc_question_id' => $question->id,
                    'statement' => $item['statement'],
                    'most_value' => $item['most'],
                    'least_value' => $item['least'],
                ]);
            }
        }
    }
}
