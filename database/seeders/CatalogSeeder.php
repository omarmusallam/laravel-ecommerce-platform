<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Store;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        $store = Store::query()->updateOrCreate(
            ['slug' => 'digital-hub'],
            [
                'name' => 'ديجيتال هب',
                'description' => 'متجر إلكتروني احترافي لبيع الأجهزة الرقمية والإلكترونيات الحديثة بإصدارات موثوقة وأسعار واضحة بالدولار.',
                'status' => 'active',
            ]
        );

        $categories = collect([
            [
                'name' => 'اللابتوبات',
                'slug' => 'laptops',
                'description' => 'لابتوبات للأعمال والدراسة والتصميم والألعاب بمواصفات حديثة ومتوازنة.',
            ],
            [
                'name' => 'الجوالات',
                'slug' => 'smartphones',
                'description' => 'هواتف ذكية من الفئات الرائدة والمتوسطة بذاكرة وسعات متنوعة.',
            ],
            [
                'name' => 'كاميرات المراقبة',
                'slug' => 'security-cameras',
                'description' => 'حلول مراقبة داخلية وخارجية بدقة عالية ورؤية ليلية واتصال ذكي.',
            ],
            [
                'name' => 'الشاشات',
                'slug' => 'monitors',
                'description' => 'شاشات عمل وألعاب وإنتاجية بدقات حديثة وأحجام متعددة.',
            ],
            [
                'name' => 'التلفزيونات',
                'slug' => 'televisions',
                'description' => 'تلفزيونات ذكية 4K وQLED مناسبة للمنزل والمكاتب وغرف العرض.',
            ],
            [
                'name' => 'أجهزة الكمبيوتر',
                'slug' => 'desktop-computers',
                'description' => 'أجهزة كمبيوتر مكتبية مجمعة باحتراف للأعمال والتصميم والألعاب.',
            ],
            [
                'name' => 'الكفرات والإكسسوارات',
                'slug' => 'cases-and-accessories',
                'description' => 'كفرات وحمايات وشواحن وإكسسوارات عملية للهواتف والأجهزة الذكية.',
            ],
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

        $tags = collect([
            ['name' => 'الأكثر مبيعًا', 'slug' => 'best-seller'],
            ['name' => 'جديد', 'slug' => 'new-arrival'],
            ['name' => 'احترافي', 'slug' => 'professional'],
            ['name' => 'ألعاب', 'slug' => 'gaming'],
            ['name' => 'عرض خاص', 'slug' => 'special-offer'],
        ])->mapWithKeys(function (array $tag) {
            return [
                $tag['slug'] => Tag::query()->updateOrCreate(
                    ['slug' => $tag['slug']],
                    ['name' => $tag['name']]
                ),
            ];
        });

        $images = $this->imagePool();
        $pointer = 0;

        $products = [
            ['category' => 'laptops', 'name' => 'لابتوب Dell XPS 15', 'slug' => 'dell-xps-15-2025', 'price' => 1899, 'compare_price' => 2049, 'quantity' => 14, 'featured' => 1, 'description' => 'لابتوب فاخر بشاشة 15.6 بوصة بدقة عالية، معالج Intel Core i7، ذاكرة 16GB وSSD بسعة 1TB مناسب للأعمال الاحترافية وصناعة المحتوى.', 'tags' => ['best-seller', 'professional']],
            ['category' => 'laptops', 'name' => 'لابتوب Lenovo ThinkPad E14', 'slug' => 'lenovo-thinkpad-e14-gen6', 'price' => 999, 'compare_price' => 1099, 'quantity' => 18, 'featured' => 0, 'description' => 'لابتوب أعمال متين مع معالج Ryzen 7 وذاكرة 16GB وتخزين SSD 512GB ولوحة مفاتيح مريحة للعمل المكتبي والدراسة.', 'tags' => ['professional', 'special-offer']],
            ['category' => 'laptops', 'name' => 'لابتوب ASUS ROG Strix G16', 'slug' => 'asus-rog-strix-g16', 'price' => 1749, 'compare_price' => 1899, 'quantity' => 9, 'featured' => 1, 'description' => 'جهاز ألعاب قوي بكرت RTX 4060 وشاشة 165Hz ومعالج Intel Core i7 لتجربة سلسة في الألعاب والبث والتصميم.', 'tags' => ['gaming', 'new-arrival']],
            ['category' => 'smartphones', 'name' => 'Apple iPhone 14 128GB', 'slug' => 'apple-iphone-14-128gb', 'price' => 799, 'compare_price' => 879, 'quantity' => 25, 'featured' => 1, 'description' => 'هاتف ذكي بشاشة Super Retina XDR وكاميرا مزدوجة وأداء سريع مع بطارية مستقرة للاستخدام اليومي والتصوير.', 'tags' => ['best-seller', 'new-arrival']],
            ['category' => 'smartphones', 'name' => 'Samsung Galaxy S24 256GB', 'slug' => 'samsung-galaxy-s24-256gb', 'price' => 899, 'compare_price' => 969, 'quantity' => 20, 'featured' => 1, 'description' => 'هاتف رائد بشاشة AMOLED مبهرة وأداء قوي وكاميرات متعددة مع مزايا ذكاء اصطناعي وتجربة استخدام متقدمة.', 'tags' => ['best-seller', 'professional']],
            ['category' => 'smartphones', 'name' => 'Xiaomi 14T Pro 512GB', 'slug' => 'xiaomi-14t-pro-512gb', 'price' => 699, 'compare_price' => 769, 'quantity' => 16, 'featured' => 0, 'description' => 'هاتف بمواصفات عالية وسعة تخزين كبيرة وشحن سريع جدًا وشاشة ممتازة لمحبي الأداء والسعر المتوازن.', 'tags' => ['special-offer', 'new-arrival']],
            ['category' => 'security-cameras', 'name' => 'كاميرا مراقبة Hikvision 4MP خارجية', 'slug' => 'hikvision-outdoor-camera-4mp', 'price' => 129, 'compare_price' => 149, 'quantity' => 30, 'featured' => 0, 'description' => 'كاميرا مراقبة خارجية بدقة 4 ميجابكسل مع رؤية ليلية ومقاومة للعوامل الجوية وتسجيل واضح للمداخل والساحات.', 'tags' => ['professional']],
            ['category' => 'security-cameras', 'name' => 'كاميرا مراقبة منزلية TP-Link Tapo C210', 'slug' => 'tp-link-tapo-c210', 'price' => 49, 'compare_price' => 59, 'quantity' => 42, 'featured' => 0, 'description' => 'كاميرا داخلية ذكية بدقة 2K مع دوران أفقي وعمودي وتنبيهات حركة ومحادثة ثنائية الاتجاه.', 'tags' => ['best-seller', 'special-offer']],
            ['category' => 'security-cameras', 'name' => 'طقم كاميرات Dahua 8 قنوات', 'slug' => 'dahua-8-channel-camera-kit', 'price' => 459, 'compare_price' => 519, 'quantity' => 11, 'featured' => 1, 'description' => 'باقة مراقبة متكاملة تشمل جهاز تسجيل و4 كاميرات خارجية ودعم للمشاهدة عن بعد للمنازل والمتاجر.', 'tags' => ['professional', 'special-offer']],
            ['category' => 'monitors', 'name' => 'شاشة LG UltraWide 34 بوصة', 'slug' => 'lg-ultrawide-34-monitor', 'price' => 429, 'compare_price' => 489, 'quantity' => 15, 'featured' => 1, 'description' => 'شاشة عريضة ممتازة للإنتاجية وتعدد المهام بدقة WQHD وألوان جيدة ومنافذ حديثة للمكاتب وصناع المحتوى.', 'tags' => ['professional', 'best-seller']],
            ['category' => 'monitors', 'name' => 'شاشة Samsung Odyssey G5 27 بوصة', 'slug' => 'samsung-odyssey-g5-27', 'price' => 289, 'compare_price' => 329, 'quantity' => 17, 'featured' => 0, 'description' => 'شاشة ألعاب 165Hz بدقة QHD مع انحناء مريح واستجابة سريعة لتجربة لعب أكثر سلاسة.', 'tags' => ['gaming', 'special-offer']],
            ['category' => 'monitors', 'name' => 'شاشة Dell 24 بوصة للأعمال', 'slug' => 'dell-24-business-monitor', 'price' => 179, 'compare_price' => 209, 'quantity' => 26, 'featured' => 0, 'description' => 'شاشة عملية بحواف نحيفة ودقة Full HD ومناسبة للمكاتب ونقاط البيع والعمل اليومي المستمر.', 'tags' => ['professional']],
            ['category' => 'televisions', 'name' => 'تلفزيون Samsung 55 بوصة 4K Smart', 'slug' => 'samsung-55-4k-smart-tv', 'price' => 649, 'compare_price' => 729, 'quantity' => 13, 'featured' => 1, 'description' => 'تلفزيون ذكي بدقة 4K مع نظام تشغيل سريع وصوت واضح وتطبيقات بث جاهزة لغرفة المعيشة.', 'tags' => ['best-seller', 'professional']],
            ['category' => 'televisions', 'name' => 'تلفزيون TCL 65 بوصة QLED', 'slug' => 'tcl-65-qled-tv', 'price' => 799, 'compare_price' => 899, 'quantity' => 10, 'featured' => 1, 'description' => 'شاشة QLED كبيرة مناسبة للترفيه المنزلي بجودة ألوان ممتازة ودعم HDR واتصال ذكي متكامل.', 'tags' => ['new-arrival', 'special-offer']],
            ['category' => 'televisions', 'name' => 'تلفزيون Xiaomi A Pro 43 بوصة', 'slug' => 'xiaomi-a-pro-43-tv', 'price' => 339, 'compare_price' => 389, 'quantity' => 19, 'featured' => 0, 'description' => 'تلفزيون اقتصادي ذكي بدقة 4K ومناسب للشقق والمكاتب وغرف النوم مع واجهة استخدام سهلة.', 'tags' => ['special-offer']],
            ['category' => 'desktop-computers', 'name' => 'كمبيوتر مكتبي للألعاب RTX 4070', 'slug' => 'gaming-desktop-rtx-4070', 'price' => 1699, 'compare_price' => 1829, 'quantity' => 8, 'featured' => 1, 'description' => 'تجميعة ألعاب واحتراف بمعالج Ryzen 7 وكرت RTX 4070 وذاكرة 32GB وتخزين SSD سريع.', 'tags' => ['gaming', 'professional']],
            ['category' => 'desktop-computers', 'name' => 'كمبيوتر مكتبي للأعمال Core i5', 'slug' => 'business-desktop-core-i5', 'price' => 649, 'compare_price' => 719, 'quantity' => 21, 'featured' => 0, 'description' => 'جهاز مكتبي موثوق للشركات والمحاسبة وإدارة المهام اليومية مع أداء ثابت وتصميم سهل الصيانة.', 'tags' => ['professional', 'best-seller']],
            ['category' => 'desktop-computers', 'name' => 'وركستيشن للتصميم والمونتاج', 'slug' => 'creative-workstation-pc', 'price' => 2199, 'compare_price' => 2399, 'quantity' => 6, 'featured' => 1, 'description' => 'وركستيشن قوية للمونتاج وثري دي والتصميم بذاكرة 64GB ومعالج متعدد الأنوية وتبريد احترافي.', 'tags' => ['professional', 'new-arrival']],
            ['category' => 'cases-and-accessories', 'name' => 'كفر حماية MagSafe لهواتف iPhone', 'slug' => 'magsafe-iphone-case', 'price' => 29, 'compare_price' => 39, 'quantity' => 60, 'featured' => 0, 'description' => 'كفر عملي بخامات متينة ودعم للشحن المغناطيسي مع حواف حماية مرتفعة للكاميرا والشاشة.', 'tags' => ['best-seller', 'special-offer']],
            ['category' => 'cases-and-accessories', 'name' => 'شاحن جداري USB-C سريع 65W', 'slug' => 'usb-c-fast-charger-65w', 'price' => 39, 'compare_price' => 49, 'quantity' => 55, 'featured' => 0, 'description' => 'شاحن سريع مناسب للهواتف واللابتوبات الخفيفة مع تقنيات حماية ذكية وحجم صغير للحمل.', 'tags' => ['special-offer']],
            ['category' => 'cases-and-accessories', 'name' => 'ستاند لابتوب ألمنيوم قابل للتعديل', 'slug' => 'adjustable-aluminum-laptop-stand', 'price' => 45, 'compare_price' => 55, 'quantity' => 28, 'featured' => 0, 'description' => 'حامل لابتوب أنيق يساعد على تحسين وضعية الجلوس وتهوية الجهاز أثناء العمل الطويل.', 'tags' => ['professional', 'new-arrival']],
        ];

        foreach ($products as $item) {
            $image = $images[$pointer % count($images)];
            $extraImages = [
                $images[($pointer + 1) % count($images)],
                $images[($pointer + 2) % count($images)],
            ];
            $pointer += 3;

            $product = Product::query()->updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'name' => $item['name'],
                    'description' => $item['description'],
                    'image' => $image,
                    'category_id' => $categories[$item['category']]->id,
                    'store_id' => $store->id,
                    'price' => $item['price'],
                    'compare_price' => $item['compare_price'],
                    'quantity' => $item['quantity'],
                    'featured' => $item['featured'],
                    'status' => 'active',
                ]
            );

            $product->tags()->sync(
                collect($item['tags'])->map(fn (string $slug) => $tags[$slug]->id)->all()
            );

            ProductImage::query()->where('product_id', $product->id)->delete();

            foreach (collect([$image, ...$extraImages])->unique() as $galleryImage) {
                ProductImage::query()->create([
                    'product_id' => $product->id,
                    'image' => $galleryImage,
                ]);
            }
        }
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
