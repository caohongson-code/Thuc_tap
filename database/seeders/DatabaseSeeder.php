<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Tạo dữ liệu theo thứ tự để tránh lỗi foreign key
        $this->call([
            // 1. Tạo Categories trước
            CategorySeeder::class,
            // 2. Tạo Users
            UserSeeder::class,
            // 3. Tạo Products (cần categories)
            ProductSeeder::class,
            // 4. Tạo ProductVariants (cần products)
            ProductVariantSeeder::class,
            // 5. Tạo Images (cần products)
            ImageSeeder::class,
            // 6. Tạo Orders (cần users)
            OrderSeeder::class,
            // 7. Tạo OrderItems (cần orders và products)
            OrderItemSeeder::class,
            // 8. Tạo Payments (cần orders)
            PaymentSeeder::class,
            // 9. Tạo Carts (cần users và products)
            CartSeeder::class,
            // 10. Tạo CartItems (cần carts và products)
            CartItemSeeder::class,
        ]);
    }
}
