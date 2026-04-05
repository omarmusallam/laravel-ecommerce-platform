<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Store;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class EnglishCatalogSeeder extends Seeder
{
    public function run(): void
    {
        $stores = $this->seedStores();
        $categories = $this->seedCategories();
        $tags = $this->seedTags();
        $images = $this->imagePool();
        $pointer = 0;

        foreach ($this->catalogBlueprint() as $index => $item) {
            $primaryImage = $images[$pointer % count($images)];
            $galleryImages = [
                $primaryImage,
                $images[($pointer + 1) % count($images)],
                $images[($pointer + 2) % count($images)],
            ];
            $pointer += 3;

            $product = Product::query()->updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'name' => $item['name'],
                    'slug' => $item['slug'],
                    'description' => $item['description'],
                    'image' => $primaryImage,
                    'category_id' => $categories[$item['category']]->id,
                    'store_id' => $stores[$item['store']]->id,
                    'price' => $item['price'],
                    'compare_price' => $item['compare_price'],
                    'quantity' => $item['quantity'],
                    'featured' => $index < 14 ? 1 : 0,
                    'status' => 'active',
                ]
            );

            $product->tags()->sync(
                collect($item['tags'])->map(fn (string $slug) => $tags[$slug]->id)->all()
            );

            ProductImage::query()->where('product_id', $product->id)->delete();

            foreach (collect($galleryImages)->unique()->values() as $galleryImage) {
                ProductImage::query()->create([
                    'product_id' => $product->id,
                    'image' => $galleryImage,
                ]);
            }
        }
    }

    protected function seedStores()
    {
        return collect([
            [
                'slug' => 'shopgrids-central',
                'name' => 'ShopGrids Central',
                'description' => 'The flagship ShopGrids store for premium electronics, accessories, and everyday best-sellers.',
            ],
            [
                'slug' => 'tech-harbor',
                'name' => 'Tech Harbor',
                'description' => 'A curated store for mobile devices, audio gear, and daily carry essentials.',
            ],
            [
                'slug' => 'urban-devices',
                'name' => 'Urban Devices',
                'description' => 'Compact electronics and modern productivity products for fast-moving city lifestyles.',
            ],
            [
                'slug' => 'nextwave-electronics',
                'name' => 'NextWave Electronics',
                'description' => 'Feature-rich hardware and connected devices for modern homes and creative teams.',
            ],
            [
                'slug' => 'prime-office-tech',
                'name' => 'Prime Office Tech',
                'description' => 'Professional equipment built for business desks, hybrid work, and efficient setups.',
            ],
        ])->mapWithKeys(function (array $store) {
            return [
                $store['slug'] => Store::query()->updateOrCreate(
                    ['slug' => $store['slug']],
                    [
                        'name' => $store['name'],
                        'description' => $store['description'],
                        'status' => 'active',
                    ]
                ),
            ];
        });
    }

    protected function seedCategories()
    {
        return collect([
            ['slug' => 'laptops', 'name' => 'Laptops', 'description' => 'Portable computers for work, study, gaming, and creative production.'],
            ['slug' => 'smartphones', 'name' => 'Smartphones', 'description' => 'Premium and mid-range phones for communication, photography, and daily use.'],
            ['slug' => 'monitors', 'name' => 'Monitors', 'description' => 'Display solutions for office desks, gaming setups, and creative workstations.'],
            ['slug' => 'security-cameras', 'name' => 'Security Cameras', 'description' => 'Indoor and outdoor smart surveillance devices for homes and offices.'],
            ['slug' => 'accessories', 'name' => 'Accessories', 'description' => 'Chargers, stands, hubs, cases, and practical add-ons for modern devices.'],
            ['slug' => 'tablets', 'name' => 'Tablets', 'description' => 'Versatile tablets for sketching, media, note-taking, and mobile productivity.'],
            ['slug' => 'audio', 'name' => 'Audio', 'description' => 'Headphones, earbuds, speakers, and microphones designed for clear everyday listening.'],
        ])->mapWithKeys(function (array $category) {
            return [
                $category['slug'] => Category::query()->updateOrCreate(
                    ['slug' => $category['slug']],
                    [
                        'name' => $category['name'],
                        'description' => $category['description'],
                        'status' => 'active',
                    ]
                ),
            ];
        });
    }

    protected function seedTags()
    {
        return collect([
            ['slug' => 'best-seller', 'name' => 'Best Seller'],
            ['slug' => 'new-arrival', 'name' => 'New Arrival'],
            ['slug' => 'professional', 'name' => 'Professional'],
            ['slug' => 'gaming', 'name' => 'Gaming'],
            ['slug' => 'special-offer', 'name' => 'Special Offer'],
            ['slug' => 'portable', 'name' => 'Portable'],
            ['slug' => 'home-office', 'name' => 'Home Office'],
        ])->mapWithKeys(function (array $tag) {
            return [
                $tag['slug'] => Tag::query()->updateOrCreate(
                    ['slug' => $tag['slug']],
                    ['name' => $tag['name']]
                ),
            ];
        });
    }

    protected function catalogBlueprint(): array
    {
        $categories = [
            'laptops' => [
                ['name' => 'Dell XPS 15', 'price' => 1899, 'compare_price' => 2049, 'quantity' => 12, 'store' => 'shopgrids-central', 'tags' => ['best-seller', 'professional'], 'description' => 'A premium 15-inch laptop with strong performance, long battery life, and a refined aluminum build.'],
                ['name' => 'ASUS ROG Strix G16', 'price' => 1749, 'compare_price' => 1899, 'quantity' => 8, 'store' => 'nextwave-electronics', 'tags' => ['gaming', 'new-arrival'], 'description' => 'A high-performance gaming laptop designed for smooth play, streaming, and demanding creative workloads.'],
                ['name' => 'Lenovo ThinkPad X1 Carbon', 'price' => 1649, 'compare_price' => 1799, 'quantity' => 10, 'store' => 'prime-office-tech', 'tags' => ['professional', 'home-office'], 'description' => 'A lightweight business laptop with a dependable keyboard, sharp display, and all-day productivity focus.'],
                ['name' => 'HP Spectre x360 14', 'price' => 1499, 'compare_price' => 1629, 'quantity' => 9, 'store' => 'shopgrids-central', 'tags' => ['portable', 'professional'], 'description' => 'A premium convertible laptop with touchscreen flexibility for work, sketching, and travel.'],
                ['name' => 'Apple MacBook Air M3', 'price' => 1399, 'compare_price' => 1499, 'quantity' => 14, 'store' => 'urban-devices', 'tags' => ['best-seller', 'portable'], 'description' => 'A thin and efficient laptop with excellent battery life for everyday professional and student use.'],
                ['name' => 'Acer Swift Go 14', 'price' => 999, 'compare_price' => 1099, 'quantity' => 16, 'store' => 'tech-harbor', 'tags' => ['portable', 'special-offer'], 'description' => 'A compact laptop with a vibrant display and a balanced performance profile for daily productivity.'],
                ['name' => 'MSI Creator Z16', 'price' => 1999, 'compare_price' => 2149, 'quantity' => 7, 'store' => 'nextwave-electronics', 'tags' => ['professional', 'new-arrival'], 'description' => 'A creator-focused laptop with strong graphics power and a color-rich display for editing workflows.'],
                ['name' => 'Samsung Galaxy Book4 Pro', 'price' => 1549, 'compare_price' => 1679, 'quantity' => 11, 'store' => 'urban-devices', 'tags' => ['portable', 'professional'], 'description' => 'A slim premium notebook designed for modern multitasking, video calls, and polished everyday use.'],
                ['name' => 'Razer Blade 14', 'price' => 2199, 'compare_price' => 2349, 'quantity' => 6, 'store' => 'shopgrids-central', 'tags' => ['gaming', 'portable'], 'description' => 'A compact gaming laptop with premium materials and high-refresh performance for travel-friendly power.'],
                ['name' => 'Dell Inspiron 14 Plus', 'price' => 1199, 'compare_price' => 1299, 'quantity' => 13, 'store' => 'prime-office-tech', 'tags' => ['home-office', 'special-offer'], 'description' => 'A practical laptop for home offices, productivity apps, and everyday browsing with dependable speed.'],
            ],
            'smartphones' => [
                ['name' => 'Apple iPhone 14 128GB', 'price' => 799, 'compare_price' => 879, 'quantity' => 20, 'store' => 'shopgrids-central', 'tags' => ['best-seller', 'portable'], 'description' => 'A reliable smartphone with polished performance, strong cameras, and a bright all-around display.'],
                ['name' => 'Samsung Galaxy S24 256GB', 'price' => 899, 'compare_price' => 969, 'quantity' => 16, 'store' => 'tech-harbor', 'tags' => ['best-seller', 'new-arrival'], 'description' => 'A flagship Android phone with a vivid screen, excellent photos, and powerful everyday responsiveness.'],
                ['name' => 'Google Pixel 8 Pro', 'price' => 949, 'compare_price' => 1029, 'quantity' => 12, 'store' => 'urban-devices', 'tags' => ['professional', 'portable'], 'description' => 'A premium smartphone with intelligent photography tools and a clean software experience.'],
                ['name' => 'OnePlus 12 256GB', 'price' => 829, 'compare_price' => 899, 'quantity' => 15, 'store' => 'nextwave-electronics', 'tags' => ['new-arrival', 'special-offer'], 'description' => 'A high-speed Android device with fast charging, fluid performance, and a crisp flagship display.'],
                ['name' => 'Xiaomi 14 256GB', 'price' => 759, 'compare_price' => 839, 'quantity' => 14, 'store' => 'tech-harbor', 'tags' => ['portable', 'special-offer'], 'description' => 'A sleek smartphone built for vibrant media, capable cameras, and smooth daily multitasking.'],
                ['name' => 'Motorola Edge 50 Pro', 'price' => 649, 'compare_price' => 719, 'quantity' => 18, 'store' => 'urban-devices', 'tags' => ['portable', 'new-arrival'], 'description' => 'A balanced smartphone with a slim design, premium finish, and quick charging support.'],
                ['name' => 'Nothing Phone 2', 'price' => 629, 'compare_price' => 699, 'quantity' => 11, 'store' => 'nextwave-electronics', 'tags' => ['portable', 'new-arrival'], 'description' => 'A modern Android handset with distinctive design details and smooth everyday performance.'],
                ['name' => 'Sony Xperia 1 V', 'price' => 1199, 'compare_price' => 1299, 'quantity' => 7, 'store' => 'shopgrids-central', 'tags' => ['professional', 'portable'], 'description' => 'A premium media-focused smartphone with pro-level camera features and cinematic display quality.'],
                ['name' => 'Samsung Galaxy A55', 'price' => 449, 'compare_price' => 499, 'quantity' => 24, 'store' => 'prime-office-tech', 'tags' => ['best-seller', 'special-offer'], 'description' => 'A dependable mid-range smartphone with a bright display, long battery life, and solid daily value.'],
                ['name' => 'Apple iPhone 15 Plus', 'price' => 999, 'compare_price' => 1099, 'quantity' => 10, 'store' => 'shopgrids-central', 'tags' => ['best-seller', 'new-arrival'], 'description' => 'A larger iPhone with long battery life, excellent cameras, and a premium everyday experience.'],
            ],
            'monitors' => [
                ['name' => 'LG UltraWide 34 Monitor', 'price' => 429, 'compare_price' => 489, 'quantity' => 14, 'store' => 'prime-office-tech', 'tags' => ['professional', 'best-seller'], 'description' => 'A wide display that gives professionals and multitaskers more room for productive workflows.'],
                ['name' => 'Samsung Odyssey G5 27', 'price' => 289, 'compare_price' => 329, 'quantity' => 17, 'store' => 'nextwave-electronics', 'tags' => ['gaming', 'special-offer'], 'description' => 'A responsive QHD gaming monitor with immersive visuals and smooth motion handling.'],
                ['name' => 'Dell UltraSharp U2723QE', 'price' => 649, 'compare_price' => 719, 'quantity' => 9, 'store' => 'prime-office-tech', 'tags' => ['professional', 'home-office'], 'description' => 'A premium 4K monitor with excellent clarity, USB-C support, and balanced color performance.'],
                ['name' => 'ASUS ProArt PA279CV', 'price' => 539, 'compare_price' => 599, 'quantity' => 8, 'store' => 'shopgrids-central', 'tags' => ['professional', 'new-arrival'], 'description' => 'A creator-focused monitor with accurate colors and practical connectivity for editing setups.'],
                ['name' => 'MSI G274QPX 27', 'price' => 399, 'compare_price' => 459, 'quantity' => 12, 'store' => 'nextwave-electronics', 'tags' => ['gaming', 'best-seller'], 'description' => 'A fast gaming monitor with a clean design, sharp detail, and fluid high-refresh gameplay.'],
                ['name' => 'BenQ GW2790', 'price' => 219, 'compare_price' => 259, 'quantity' => 18, 'store' => 'urban-devices', 'tags' => ['home-office', 'special-offer'], 'description' => 'A comfortable office monitor with eye-care features and a practical size for daily work.'],
                ['name' => 'Gigabyte M32U', 'price' => 699, 'compare_price' => 759, 'quantity' => 6, 'store' => 'shopgrids-central', 'tags' => ['gaming', 'professional'], 'description' => 'A premium 4K monitor suited for gaming, media, and detailed productivity tasks.'],
                ['name' => 'HP E24 G5', 'price' => 189, 'compare_price' => 219, 'quantity' => 20, 'store' => 'prime-office-tech', 'tags' => ['home-office', 'portable'], 'description' => 'A practical compact monitor with crisp text rendering and dependable business-ready performance.'],
                ['name' => 'ViewSonic VP2768a', 'price' => 469, 'compare_price' => 519, 'quantity' => 10, 'store' => 'urban-devices', 'tags' => ['professional', 'home-office'], 'description' => 'A color-accurate productivity monitor designed for clean desktop setups and content tasks.'],
                ['name' => 'AOC CQ32G3SE', 'price' => 329, 'compare_price' => 379, 'quantity' => 13, 'store' => 'tech-harbor', 'tags' => ['gaming', 'special-offer'], 'description' => 'A curved gaming monitor that blends immersion, strong contrast, and practical value.'],
            ],
            'security-cameras' => [
                ['name' => 'TP-Link Tapo C210', 'price' => 49, 'compare_price' => 59, 'quantity' => 30, 'store' => 'urban-devices', 'tags' => ['best-seller', 'special-offer'], 'description' => 'An indoor security camera with 2K clarity, motion tracking, and simple smart-home integration.'],
                ['name' => 'Hikvision Outdoor Camera 4MP', 'price' => 129, 'compare_price' => 149, 'quantity' => 22, 'store' => 'prime-office-tech', 'tags' => ['professional'], 'description' => 'A weather-resistant outdoor camera for crisp footage and dependable perimeter monitoring.'],
                ['name' => 'Eufy SoloCam S220', 'price' => 149, 'compare_price' => 169, 'quantity' => 14, 'store' => 'shopgrids-central', 'tags' => ['new-arrival', 'portable'], 'description' => 'A smart wireless outdoor camera with solar charging support and clean installation flexibility.'],
                ['name' => 'Arlo Essential 2K', 'price' => 179, 'compare_price' => 199, 'quantity' => 11, 'store' => 'tech-harbor', 'tags' => ['best-seller', 'new-arrival'], 'description' => 'A smart security camera with clear recording, app alerts, and practical home monitoring features.'],
                ['name' => 'Reolink Duo 2 WiFi', 'price' => 189, 'compare_price' => 219, 'quantity' => 9, 'store' => 'nextwave-electronics', 'tags' => ['professional', 'special-offer'], 'description' => 'A dual-lens camera with a wide field of view for driveways, storefronts, and large outdoor areas.'],
                ['name' => 'Google Nest Cam Indoor', 'price' => 119, 'compare_price' => 139, 'quantity' => 17, 'store' => 'urban-devices', 'tags' => ['portable', 'best-seller'], 'description' => 'An indoor smart camera with clean design, dependable notifications, and easy app setup.'],
                ['name' => 'Ring Stick Up Cam Pro', 'price' => 159, 'compare_price' => 179, 'quantity' => 13, 'store' => 'tech-harbor', 'tags' => ['new-arrival', 'special-offer'], 'description' => 'A versatile security camera for indoor or outdoor placement with a simple mounting system.'],
                ['name' => 'Blink Outdoor 4', 'price' => 99, 'compare_price' => 119, 'quantity' => 18, 'store' => 'prime-office-tech', 'tags' => ['special-offer', 'portable'], 'description' => 'A battery-powered outdoor camera for quick installation and dependable everyday coverage.'],
                ['name' => 'Ubiquiti G5 Bullet', 'price' => 209, 'compare_price' => 239, 'quantity' => 8, 'store' => 'nextwave-electronics', 'tags' => ['professional', 'home-office'], 'description' => 'A business-ready camera built for stable network surveillance and clean long-term deployment.'],
                ['name' => 'EZVIZ C8PF', 'price' => 139, 'compare_price' => 159, 'quantity' => 12, 'store' => 'shopgrids-central', 'tags' => ['best-seller', 'special-offer'], 'description' => 'A flexible outdoor camera with broad coverage and smooth app-based remote monitoring.'],
            ],
            'accessories' => [
                ['name' => 'USB-C Fast Charger 65W', 'price' => 39, 'compare_price' => 49, 'quantity' => 40, 'store' => 'shopgrids-central', 'tags' => ['special-offer', 'portable'], 'description' => 'A compact fast charger for phones, tablets, and lightweight laptops with modern USB-C support.'],
                ['name' => 'Adjustable Aluminum Laptop Stand', 'price' => 45, 'compare_price' => 55, 'quantity' => 24, 'store' => 'prime-office-tech', 'tags' => ['professional', 'new-arrival'], 'description' => 'A sturdy adjustable stand that improves posture and airflow during longer work sessions.'],
                ['name' => 'Anker USB-C Hub 8-in-1', 'price' => 69, 'compare_price' => 79, 'quantity' => 26, 'store' => 'urban-devices', 'tags' => ['home-office', 'best-seller'], 'description' => 'A clean desktop hub that expands connectivity for laptops, tablets, and external displays.'],
                ['name' => 'Belkin MagSafe Charger', 'price' => 44, 'compare_price' => 54, 'quantity' => 22, 'store' => 'tech-harbor', 'tags' => ['portable', 'special-offer'], 'description' => 'A magnetic wireless charger for streamlined desk setups and travel-friendly charging.'],
                ['name' => 'Logitech MX Keys Mini', 'price' => 99, 'compare_price' => 119, 'quantity' => 15, 'store' => 'prime-office-tech', 'tags' => ['professional', 'portable'], 'description' => 'A compact premium keyboard with a refined typing experience and multi-device support.'],
                ['name' => 'UGREEN Laptop Sleeve 14"', 'price' => 29, 'compare_price' => 35, 'quantity' => 30, 'store' => 'urban-devices', 'tags' => ['portable', 'new-arrival'], 'description' => 'A slim protective sleeve that keeps daily-carry laptops safe without adding bulk.'],
                ['name' => 'Apple Magic Mouse', 'price' => 79, 'compare_price' => 89, 'quantity' => 19, 'store' => 'shopgrids-central', 'tags' => ['professional', 'best-seller'], 'description' => 'A minimalist wireless mouse with touch gestures for modern desks and clean setups.'],
                ['name' => 'Samsung T7 Shield 1TB', 'price' => 109, 'compare_price' => 129, 'quantity' => 17, 'store' => 'nextwave-electronics', 'tags' => ['portable', 'professional'], 'description' => 'A rugged external SSD with fast transfers and dependable storage for mobile workflows.'],
                ['name' => 'Baseus GaN Charger 100W', 'price' => 59, 'compare_price' => 69, 'quantity' => 21, 'store' => 'tech-harbor', 'tags' => ['special-offer', 'portable'], 'description' => 'A powerful multi-device charger designed for compact workstations and travel bags.'],
                ['name' => 'Twelve South Curve Stand', 'price' => 54, 'compare_price' => 64, 'quantity' => 16, 'store' => 'shopgrids-central', 'tags' => ['home-office', 'new-arrival'], 'description' => 'A refined desk stand that lifts laptops for cleaner posture and more elegant desk organization.'],
            ],
            'tablets' => [
                ['name' => 'Apple iPad Air 11"', 'price' => 699, 'compare_price' => 769, 'quantity' => 13, 'store' => 'shopgrids-central', 'tags' => ['best-seller', 'portable'], 'description' => 'A versatile tablet for notes, media, light creative work, and polished everyday use.'],
                ['name' => 'Samsung Galaxy Tab S9', 'price' => 799, 'compare_price' => 879, 'quantity' => 11, 'store' => 'tech-harbor', 'tags' => ['new-arrival', 'professional'], 'description' => 'A premium Android tablet with a vivid display and flexible use for work or entertainment.'],
                ['name' => 'Lenovo Tab P12', 'price' => 429, 'compare_price' => 479, 'quantity' => 15, 'store' => 'urban-devices', 'tags' => ['portable', 'special-offer'], 'description' => 'A spacious tablet with good battery life and practical performance for media and study.'],
                ['name' => 'Microsoft Surface Pro 10', 'price' => 1499, 'compare_price' => 1599, 'quantity' => 7, 'store' => 'prime-office-tech', 'tags' => ['professional', 'home-office'], 'description' => 'A premium 2-in-1 device that bridges tablet flexibility with laptop-style productivity.'],
                ['name' => 'Xiaomi Pad 6', 'price' => 379, 'compare_price' => 429, 'quantity' => 18, 'store' => 'nextwave-electronics', 'tags' => ['special-offer', 'portable'], 'description' => 'A sleek tablet with strong everyday value for reading, streaming, and light work.'],
                ['name' => 'OnePlus Pad', 'price' => 479, 'compare_price' => 529, 'quantity' => 12, 'store' => 'tech-harbor', 'tags' => ['new-arrival', 'portable'], 'description' => 'A modern Android tablet with smooth performance and a distinctive productivity-friendly screen.'],
                ['name' => 'Apple iPad 10th Gen', 'price' => 449, 'compare_price' => 499, 'quantity' => 20, 'store' => 'shopgrids-central', 'tags' => ['best-seller', 'special-offer'], 'description' => 'A dependable mainstream tablet with a clean interface and broad support for everyday tasks.'],
                ['name' => 'Huawei MatePad 11.5', 'price' => 399, 'compare_price' => 459, 'quantity' => 10, 'store' => 'urban-devices', 'tags' => ['portable', 'professional'], 'description' => 'A capable tablet built for multitasking, note-taking, and practical mobile productivity.'],
                ['name' => 'Amazon Fire Max 11', 'price' => 229, 'compare_price' => 259, 'quantity' => 22, 'store' => 'nextwave-electronics', 'tags' => ['special-offer', 'portable'], 'description' => 'A value-focused tablet suited for browsing, streaming, and family-friendly entertainment.'],
                ['name' => 'Lenovo Yoga Tab 13', 'price' => 649, 'compare_price' => 719, 'quantity' => 9, 'store' => 'prime-office-tech', 'tags' => ['professional', 'new-arrival'], 'description' => 'A large-screen tablet with a built-in stand for flexible viewing and productivity use.'],
            ],
            'audio' => [
                ['name' => 'Sony WH-1000XM5', 'price' => 349, 'compare_price' => 399, 'quantity' => 14, 'store' => 'shopgrids-central', 'tags' => ['best-seller', 'portable'], 'description' => 'Premium wireless headphones with excellent noise cancellation and a refined listening profile.'],
                ['name' => 'Apple AirPods Pro 2', 'price' => 229, 'compare_price' => 249, 'quantity' => 21, 'store' => 'tech-harbor', 'tags' => ['best-seller', 'portable'], 'description' => 'Compact wireless earbuds with strong everyday comfort, clean sound, and practical convenience.'],
                ['name' => 'Bose QuietComfort Ultra', 'price' => 379, 'compare_price' => 429, 'quantity' => 9, 'store' => 'urban-devices', 'tags' => ['professional', 'new-arrival'], 'description' => 'Premium over-ear headphones designed for immersive travel, focus, and comfortable long listening sessions.'],
                ['name' => 'JBL Charge 5', 'price' => 159, 'compare_price' => 179, 'quantity' => 18, 'store' => 'nextwave-electronics', 'tags' => ['portable', 'special-offer'], 'description' => 'A durable Bluetooth speaker with strong battery life and room-filling sound for everyday use.'],
                ['name' => 'Audio-Technica ATH-M50X', 'price' => 149, 'compare_price' => 169, 'quantity' => 16, 'store' => 'prime-office-tech', 'tags' => ['professional', 'best-seller'], 'description' => 'A trusted pair of monitoring headphones known for balanced sound and dependable build quality.'],
                ['name' => 'Marshall Emberton II', 'price' => 169, 'compare_price' => 189, 'quantity' => 12, 'store' => 'shopgrids-central', 'tags' => ['portable', 'new-arrival'], 'description' => 'A stylish portable speaker with rich sound and a design that complements modern interiors.'],
                ['name' => 'Shure MV7 Microphone', 'price' => 249, 'compare_price' => 279, 'quantity' => 8, 'store' => 'prime-office-tech', 'tags' => ['professional', 'home-office'], 'description' => 'A polished USB microphone for remote meetings, podcasts, and clean voice capture.'],
                ['name' => 'Samsung Galaxy Buds2 Pro', 'price' => 189, 'compare_price' => 219, 'quantity' => 19, 'store' => 'tech-harbor', 'tags' => ['portable', 'special-offer'], 'description' => 'Compact premium earbuds with good comfort, detailed sound, and strong day-to-day practicality.'],
                ['name' => 'Anker Soundcore Liberty 4', 'price' => 129, 'compare_price' => 149, 'quantity' => 20, 'store' => 'urban-devices', 'tags' => ['best-seller', 'special-offer'], 'description' => 'Wireless earbuds with strong value, balanced sound, and practical features for busy daily use.'],
                ['name' => 'Logitech G Pro X 2 Headset', 'price' => 229, 'compare_price' => 259, 'quantity' => 11, 'store' => 'nextwave-electronics', 'tags' => ['gaming', 'new-arrival'], 'description' => 'A gaming headset tuned for clear communication, long sessions, and clean wireless performance.'],
            ],
        ];

        $products = [];

        foreach ($categories as $categorySlug => $items) {
            foreach ($items as $item) {
                $products[] = array_merge($item, [
                    'category' => $categorySlug,
                    'slug' => Str::slug($item['name']),
                ]);
            }
        }

        return $products;
    }

    protected function imagePool(): array
    {
        $images = collect(File::files(public_path('uploads')))
            ->filter(fn ($file) => in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'webp'], true))
            ->map(fn ($file) => 'uploads/' . $file->getFilename())
            ->values()
            ->all();

        if (empty($images)) {
            return ['assets/images/products/product-default.jpg'];
        }

        return $images;
    }
}
