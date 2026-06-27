<?php

namespace Database\Seeders;

use App\Models\ac_brands;
use App\Models\ac_capacities;
use App\Models\ac_types;
use App\Models\Service;
use App\Models\Technician;
use Illuminate\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedAcCapacities();
        $this->seedAcBrands();
        $this->seedAcTypes();
        $this->seedServices();
        $this->seedTechnicians();
    }

    private function seedAcCapacities(): void
    {
        $data = [
            ['pk' => 0.5, 'label' => '0.5 PK'],
            ['pk' => 0.75, 'label' => '0.75 PK'],
            ['pk' => 1.0, 'label' => '1 PK'],
            ['pk' => 1.5, 'label' => '1.5 PK'],
            ['pk' => 2.0, 'label' => '2 PK'],
            ['pk' => 2.5, 'label' => '2.5 PK'],
            ['pk' => 3.0, 'label' => '3 PK'],
            ['pk' => 5.0, 'label' => '5 PK'],
            ['pk' => 10.0, 'label' => '10 PK (Central)'],
        ];

        foreach ($data as $item) {
            ac_capacities::firstOrCreate(
                ['pk' => $item['pk']],
                $item
            );
        }

        $this->command->info('AC Capacities seeded: '.count($data));
    }

    private function seedAcBrands(): void
    {
        $brands = [
            ['nama' => 'Daikin', 'keterangan' => 'Merek AC Jepang, terkenal dengan efisiensi energi tinggi'],
            ['nama' => 'Panasonic', 'keterangan' => 'Merek AC Jepang dengan teknologi inverter terdepan'],
            ['nama' => 'Sharp', 'keterangan' => 'Merek AC Jepang dengan fitur Plasmacluster'],
            ['nama' => 'LG', 'keterangan' => 'Merek AC Korea dengan desain modern dan fitur smart'],
            ['nama' => 'Samsung', 'keterangan' => 'Merek AC Korea dengan teknologi Wind-Free'],
            ['nama' => 'Gree', 'keterangan' => 'Merek AC China dengan harga kompetitif'],
            ['nama' => 'Midea', 'keterangan' => 'Merek AC China yang banyak digunakan di Indonesia'],
            ['nama' => 'Polytron', 'keterangan' => 'Merek AC lokal Indonesia dengan harga terjangkau'],
            ['nama' => 'Changhong', 'keterangan' => 'Merek AC China dengan fitur lengkap'],
            ['nama' => 'Hisense', 'keterangan' => 'Merek AC China dengan teknologi terbaru'],
            ['nama' => 'Sanyo', 'keterangan' => 'Merek AC Jepang yang sudah lama dikenal'],
            ['nama' => 'Mitsubishi Electric', 'keterangan' => 'Merek AC Jepang premium dengan kualitas terbaik'],
            ['nama' => 'Toshiba', 'keterangan' => 'Merek AC Jepang dengan teknologi canggih'],
            ['nama' => 'Haier', 'keterangan' => 'Merek AC China yang telah mendunia'],
            ['nama' => 'Akari', 'keterangan' => 'Merek AC dengan harga ekonomis'],
        ];

        foreach ($brands as $brand) {
            $brand['kode'] = ac_brands::generateKode();
            ac_brands::firstOrCreate(
                ['nama' => $brand['nama']],
                $brand
            );
        }

        $this->command->info('AC Brands seeded: '.count($brands));
    }

    private function seedAcTypes(): void
    {
        $types = [
            ['nama' => 'Split Wall', 'keterangan' => 'AC split dinding, tipe paling umum untuk rumah dan kantor'],
            ['nama' => 'Cassette', 'keterangan' => 'AC cassette plafon, cocok untuk ruangan komersial'],
            ['nama' => 'Floor Standing', 'keterangan' => 'AC berdiri di lantai, cocok untuk ruangan besar'],
            ['nama' => 'Ceiling Mounted', 'keterangan' => 'AC yang dipasang di plafon'],
            ['nama' => 'Duct Connection', 'keterangan' => 'AC ducting untuk sistem central HVAC'],
            ['nama' => 'Window', 'keterangan' => 'AC jendela, model lama yang dipasang di jendela'],
            ['nama' => 'Portable', 'keterangan' => 'AC portabel yang bisa dipindah-pindah'],
            ['nama' => 'Central AC', 'keterangan' => 'Sistem AC sentral untuk gedung besar'],
            ['nama' => 'Inverter Split', 'keterangan' => 'AC split dengan teknologi inverter hemat listrik'],
            ['nama' => 'Multi Split', 'keterangan' => 'Satu outdoor unit untuk beberapa indoor unit'],
        ];

        foreach ($types as $type) {
            $type['kode'] = ac_types::generateKode();
            ac_types::firstOrCreate(
                ['nama' => $type['nama']],
                $type
            );
        }

        $this->command->info('AC Types seeded: '.count($types));
    }

    private function seedServices(): void
    {
        $services = [
            [
                'nama_layanan' => 'Cuci AC Standar',
                'harga' => 75000,
                'deskripsi' => 'Pembersihan AC secara standar meliputi filter, evaporator, dan kondensor',
            ],
            [
                'nama_layanan' => 'Cuci AC Full',
                'harga' => 150000,
                'deskripsi' => 'Pembersihan AC menyeluruh termasuk bongkar unit indoor dan outdoor',
            ],
            [
                'nama_layanan' => 'Cuci AC Inverter',
                'harga' => 175000,
                'deskripsi' => 'Pembersihan khusus untuk AC inverter dengan penanganan ekstra',
            ],
            [
                'nama_layanan' => 'Service AC Ringan',
                'harga' => 100000,
                'deskripsi' => 'Perbaikan ringan seperti kebocoran freon, pembersihan, dan pengecekan',
            ],
            [
                'nama_layanan' => 'Service AC Berat',
                'harga' => 250000,
                'deskripsi' => 'Perbaikan berat termasuk ganti kompresor, motor fan, atau PCB',
            ],
            [
                'nama_layanan' => 'Tambah Freon R32',
                'harga' => 200000,
                'deskripsi' => 'Pengisian freon R32 untuk AC jenis baru',
            ],
            [
                'nama_layanan' => 'Tambah Freon R410A',
                'harga' => 250000,
                'deskripsi' => 'Pengisian freon R410A untuk AC inverter',
            ],
            [
                'nama_layanan' => 'Tambah Freon R22',
                'harga' => 150000,
                'deskripsi' => 'Pengisian freon R22 untuk AC lama',
            ],
            [
                'nama_layanan' => 'Bongkar Pasang AC',
                'harga' => 350000,
                'deskripsi' => 'Jasa bongkar dan pasang AC ke lokasi baru',
            ],
            [
                'nama_layanan' => 'Instalasi AC Baru',
                'harga' => 500000,
                'deskripsi' => 'Instalasi AC baru lengkap dengan bracket dan pipa',
            ],
            [
                'nama_layanan' => 'Perawatan AC Bulanan',
                'harga' => 50000,
                'deskripsi' => 'Perawatan rutin bulanan untuk menjaga performa AC',
            ],
            [
                'nama_layanan' => 'Perawatan AC 3 Bulanan',
                'harga' => 100000,
                'deskripsi' => 'Perawatan berkala setiap 3 bulan sekali',
            ],
            [
                'nama_layanan' => 'Ganti Filter AC',
                'harga' => 80000,
                'deskripsi' => 'Penggantian filter AC dengan yang baru',
            ],
            [
                'nama_layanan' => 'Ganti Kapasitor',
                'harga' => 120000,
                'deskripsi' => 'Penggantian kapasitor AC yang rusak',
            ],
            [
                'nama_layanan' => 'Ganti Fan Motor',
                'harga' => 300000,
                'deskripsi' => 'Penggantian motor kipas indoor atau outdoor',
            ],
        ];

        foreach ($services as $service) {
            $service['kode_layanan'] = Service::generateKode();
            Service::firstOrCreate(
                ['nama_layanan' => $service['nama_layanan']],
                $service
            );
        }

        $this->command->info('Services seeded: '.count($services));
    }

    private function seedTechnicians(): void
    {
        $technicians = [
            ['nama' => 'Agus Pratama', 'telepon' => '081234567890', 'alamat' => 'Jl. Merdeka No. 45, Jakarta Pusat'],
            ['nama' => 'Bambang Susilo', 'telepon' => '081298765432', 'alamat' => 'Jl. Sudirman No. 12, Jakarta Selatan'],
            ['nama' => 'Rudi Hartono', 'telepon' => '082112345678', 'alamat' => 'Jl. Gatot Subroto No. 78, Jakarta Timur'],
            ['nama' => 'Hendra Gunawan', 'telepon' => '082176543210', 'alamat' => 'Jl. Ahmad Yani No. 23, Bandung'],
            ['nama' => 'Dedi Kurniawan', 'telepon' => '083123456789', 'alamat' => 'Jl. Diponegoro No. 56, Surabaya'],
            ['nama' => 'Eko Prasetyo', 'telepon' => '083198765432', 'alamat' => 'Jl. Pahlawan No. 89, Semarang'],
            ['nama' => 'Fajar Ramadhan', 'telepon' => '085612345678', 'alamat' => 'Jl. Sisingamangaraja No. 34, Medan'],
            ['nama' => 'Gilang Permana', 'telepon' => '085676543210', 'alamat' => 'Jl. Malioboro No. 67, Yogyakarta'],
            ['nama' => 'Hari Setiawan', 'telepon' => '087812345678', 'alamat' => 'Jl. Veteran No. 90, Malang'],
            ['nama' => 'Indra Lesmana', 'telepon' => '087876543210', 'alamat' => 'Jl. Gajah Mada No. 12, Denpasar'],
            ['nama' => 'Joko Wibowo', 'telepon' => '089912345678', 'alamat' => 'Jl. Pemuda No. 45, Makassar'],
            ['nama' => 'Krisna Wijaya', 'telepon' => '089976543210', 'alamat' => 'Jl. Teuku Umar No. 78, Palembang'],
            ['nama' => 'Lutfi Hakim', 'telepon' => '081334455667', 'alamat' => 'Jl. Imam Bonjol No. 56, Pekanbaru'],
            ['nama' => 'Mulyadi Siregar', 'telepon' => '081378901234', 'alamat' => 'Jl. Jendral Sudirman No. 23, Batam'],
            ['nama' => 'Nanda Pratama', 'telepon' => '082256789012', 'alamat' => 'Jl. Sukarno Hatta No. 89, Balikpapan'],
            ['nama' => 'Oky Firmansyah', 'telepon' => '082278901234', 'alamat' => 'Jl. WR Supratman No. 34, Manado'],
            ['nama' => 'Pandu Winata', 'telepon' => '083345678901', 'alamat' => 'Jl. Urip Sumoharjo No. 67, Pontianak'],
            ['nama' => 'Rizky Ananda', 'telepon' => '083378901234', 'alamat' => 'Jl. Soekarno Hatta No. 12, Samarinda'],
            ['nama' => 'Sandi Maulana', 'telepon' => '085756789012', 'alamat' => 'Jl. M.T. Haryono No. 78, Banjarmasin'],
            ['nama' => 'Tomi Saputra', 'telepon' => '085778901234', 'alamat' => 'Jl. Kapten Pattimura No. 45, Mataram'],
        ];

        foreach ($technicians as $tech) {
            $tech['kode_teknisi'] = Technician::generateKode();
            $tech['status'] = 'aktif';
            Technician::firstOrCreate(
                ['nama' => $tech['nama']],
                $tech
            );
        }

        $this->command->info('Technicians seeded: '.count($technicians));
    }
}
