<?php

namespace Database\Seeders;

use App\Models\Violation;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ViolationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('vi_VN');
        
        $violationTypes = [
            'Vượt đèn đỏ',
            'Chạy quá tốc độ quy định',
            'Không đội mũ bảo hiểm',
            'Dừng xe sai quy định',
            'Không có giấy phép lái xe',
            'Sử dụng điện thoại khi lái xe',
            'Không thắt dây an toàn',
            'Chở không đúng nơi quy định',
            'Lái xe dưới tác dụng của rượu bia',
            'Không biến báo khi chuyển làn'
        ];
        
        $licensePlatePrefixes = ['29A', '30A', '43A', '51A', '59A', '61A', '77A', '92A'];
        
        for ($i = 0; $i < 20; $i++) {
            $prefix = $faker->randomElement($licensePlatePrefixes);
            $number = $faker->numberBetween(100, 999);
            $suffix = $faker->numberBetween(10, 99);
            
            Violation::create([
                'violation_date' => $faker->dateTimeBetween('-6 months', 'now')->format('Y-m-d'),
                'license_plate' => $prefix . '-' . $number . '.' . $suffix,
                'full_name' => $faker->name,
                'birth_date' => $faker->dateTimeBetween('-60 years', '-20 years')->format('Y-m-d'),
                'address' => $faker->address,
                'violation_type' => $faker->randomElement($violationTypes),
            ]);
        }
    }
}
