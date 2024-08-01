<?php
declare(strict_types=1);

namespace App\Modules\Web\Helpers;

use App\Modules\Base\Entity\Photo;
use App\Modules\Setting\Entity\Office;
use App\Modules\Setting\Entity\Organization;
use App\Modules\Setting\Entity\Web;
use App\Modules\Setting\Repository\SettingRepository;
use Carbon\Carbon;

class Schema
{
    private string $url;

    //TODO Настройки Компании

    private Organization $organization;
    private Office $office;
    private Web $web;

    public function __construct(SettingRepository $settings)
    {
        $this->url = route('web.home');

        $this->organization = $settings->getOrganization();
        $this->office = $settings->getOffice();
        $this->web = $settings->getWeb();

    }

    public function HomePage()
    {
        $schema1 = $this->_webPage('store');
        $schema2 = $this->_Store();

        return $this->html($schema1) . PHP_EOL . $this->html($schema2);
    }

    /**/
    public function BreadCrumbs($breadcrumbs): string
    {
        $bread = [];
        $count = $breadcrumbs->count();
        foreach ($breadcrumbs as $index => $breadcrumb) {

            if (empty($breadcrumb->url) || $count == ($index + 1)) {
                $bread[] = [
                    '@type' => 'ListItem',
                    'position' => $index + 1,
                    'name' => $breadcrumb->title,
                ];

            } else {
                $bread[] = [
                    '@type' => 'ListItem',
                    'position' => $index + 1,
                    'item' => [
                        "@id" => $breadcrumb->url,
                        "name" => ($index == 0) ? 'Главная' : $breadcrumb->title,
                    ],
                ];
            }
        }

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            '@id' => 'breadcrumb',
            'name' => 'Хлебные крошки',
            'itemListElement' => $bread,
        ];

        return $this->html($schema);
    }

    //TODO Брать из Базы

    /*
    public function CategoryPage(Category $category)
    {
        $schema = $this->_SubCategories($category);
        return $this->html($schema);
    }

    public function CategoryProductsPage(Category $category)
    {
        $schema = $this->_Products($category);
        return $this->html($schema);
    }

    public function ProductPage(Product $product)
    {
        $id = route('web.product.view', $product->slug) . '/#' . $product->code_search;
        $schema1 = $this->_webPage(
            $id,
            $product->created_at, $product->updated_at,
            true);

        $schema2 = $this->_Product($product);
        return $this->html($schema1) . PHP_EOL . $this->html($schema2);

    }

    public function ServicePage(Service $service)
    {
        $id = route('web.service.view', $service->slug) . '/#' . $service->code_search;
        $schema1 = $this->_webPage(
            $id,
            $service->created_at, $service->updated_at,
            true);

        $schema2 = $this->_Service($service);
        return $this->html($schema1) . PHP_EOL . $this->html($schema2);
    }
    */

    private function html(array $array)
    {
        $array = array_filter($array, function ($item) {
            return !is_null($item);
        });
        $result = '<script type="application/ld+json" class="schemantra.com">' . PHP_EOL;
        $result .= json_encode($array) . PHP_EOL;
        $result .= '</script>';
        return $result;
    }

    private function _webPage(string $id = '', Carbon $created_at = null, Carbon $updated_at = null, bool $breadcrumb = false)
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => "WebPage",
            'url' => $this->url,
            'datePublished' => $date ?? now(),
            'dateModified' => now(),
            'description' => '',
            'inLanguage' => 'ru-RU',
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => $this->url . '/search?q={search_term_string}'
                ],
                'query-input' => 'required name=search_term_string'
            ],
            'provider' => $this->_Organization(),
            "breadcrumb" => $breadcrumb ? ["@id" => "breadcrumb"] : null,
            "mainEntity" => [
                "@id" => $id,
            ]
        ];
    }

    private function _Organization()
    {
        return [
            "@type" => "Organization",
            "@id" => $this->url . "/#organization",
            "name" => $this->organization->name,
            "url" => $this->url,
            "logo" => [
                "@type" => "ImageObject",
                //TODO После добавления Галереи
                "url" => "https://nordihome.com/wp-content/uploads/2023/07/logo-nordi-home-1.png",
                "contentUrl" => "https://nordihome.com/wp-content/uploads/2023/07/logo-nordi-home-1.png",
                "width" => 2047,
                "height" => 2141,
                "caption" => "NORDI Home" //Alt от логотипа
            ],
            "contactPoint" => [
                "@type" => "ContactPoint",
                "contactOption" => "TollFree",
                "contactType" => "Customer Service",
                "telephone" => $this->organization->phones,
            ],
            "address" => [
                "@type" => "PostalAddress",
                "postalCode" => $this->organization->post,
                "addressLocality" => $this->organization->city,
                "streetAddress" => $this->organization->address
            ],
        ];
    }
/*
    private function _Offer(Product $product)
    {
        //"offers" =>
        return [
            "@type" => "Offer",
            "acceptedPaymentMethod" => [
                [
                    "@type" => "PaymentMethod",
                    "@id" => "https://purl.org/goodrelations/v1#ByBankTransferInAdvance"
                ],
                [
                    "@type" => "PaymentMethod",
                    "@id" => "https://purl.org/goodrelations/v1#ByInvoice"
                ],
                [
                    "@type" => "PaymentMethod",
                    "@id" => "https://purl.org/goodrelations/v1#Cash"
                ],
            ],
            "deliveryLeadTime" => [
                "@type" => "QuantitativeValue",
                "unitCode" => "DAY",
                "value" => "14"
            ],
            "inventoryLevel" => [
                "@type" => "QuantitativeValue",
                "unitCode" => "NMP",
                "value" => $product->getCountSell(),
            ],
            "hasMerchantReturnPolicy" => [
                "@type" => "MerchantReturnPolicy",
                "applicableCountry" => "RU",
                "returnPolicyCategory" => "https://schema.org/MerchantReturnFiniteReturnWindow",
                "merchantReturnDays" => 60,
                "returnMethod" => "https://schema.org/ReturnByMail",
                "returnFees" => "https://schema.org/FreeReturn"
            ],
            "warranty" => [
                "@type" => "WarrantyPromise",
                "durationOfWarranty" => [
                    "@type" => "QuantitativeValue",
                    "unitCode" => "MON",
                    "value" => "12"
                ]
            ],
            "itemCondition" => "https://schema.org/NewCondition",
            "availableDeliveryMethod" => "https://schema.org/OnSitePickup",
            "potentialAction" => [
                "@type" => "https://schema.org/BuyAction"
            ],

            "price" => $product->getLastPrice(),
            "priceCurrency" => "RUB",
            "availability" => 'https://schema.org/' . ($product->getCountSell() == 0 ? 'InStock' : 'PreOrder'),
            "seller" => [
                "@type" => "Organization",
                "name" => "ООО «Негоциант»",
                "url" => "https://nordihome.ru/",
                "brand" => [
                    "@type" => "Brand",
                    "name" => "NORDI HOME",
                    "alternateName" => ["Евро Икеа", "Евроикеа", "euroikea", "euro ikea", "nordihome", "nordi home", "нордихом", "норди хом"],
                    "sameAs" => "https://vk.com/nordihome"
                ]
            ]
        ];
    }
*/
    //Точка оказания услуг
    private function _Store()
    {
        return [
            "@context" => "https://schema.org",
            "@type" => "Store",
            "@id" => $this->url . "/#store",
            "name" => $this->office->name,
            //TODO После Галереи
            "image" => [
                "https://nordihome.ru/wp-content/uploads/2023/08/xxxl.jpg",
                "https://nordihome.ru/wp-content/uploads/2023/08/xxxl-1.jpg",
                "https://nordihome.ru/wp-content/uploads/2023/08/xxxl-2.jpg",
                "https://nordihome.ru/wp-content/uploads/2023/08/xxxl-4.jpg",
                "https://nordihome.ru/wp-content/uploads/2023/08/xxxl-3.jpg"
            ],
            "openingHours" => $this->office->open_hours,

            "paymentAccepted" => $this->office->payment, //"Наличные, QR-код, Платежи СБП, Банковские карты, Оплата по счету",
            "priceRange" => $this->office->prices,
            "telephone" => $this->office->phones,
            "address" => [
                "@type" => "PostalAddress",
                "addressLocality" => $this->office->city,
                "streetAddress" => $this->office->address
            ],
            "aggregateRating" => [
                "@type" => "aggregateRating",
                "ratingValue" => $this->office->rating_value,
                "ratingCount" => $this->office->rating_count,
                "url" => $this->office->rating_url
            ],
            "geo" => [
                "@type" => "GeoCoordinates",
                "latitude" => $this->office->latitude,
                "longitude" => $this->office->longitude
            ],
            "brand" => [
                "@type" => "Brand",
                "name" => $this->office->brand_name,
                "alternateName" => $this->office->brand_alternate,
                "sameAs" => $this->office->brand_sameas,
            ]
        ];
    }

/*
    private function _Product(Product $product)
    {
        return [
            "@context" => "https://schema.org",
            "@type" => "Product",
            "name" => $product->name,
            'description' => strip_tags($product->description),
            'image' => array_map(function (Photo $photo) {
                return [
                    $photo->getThumbUrl('card'),
                ];
            }, $product->photo()->getModels()),
            'url' => route('shop.product.view', $product->slug),
            'sku' => $product->code,
            'mpn' => $product->code,
            'id' => route('shop.product.view', $product->slug) . '/#' . $product->code_search,
            'category' => array_map(function (Category $category) {
                return [
                    "@type" => "CategoryCode",
                    "name" => $category->name,
                    "image" => route('shop.category.view', $category->slug),
                    "url" => $category->getImage(),
                ];
            }, $product->categories()->getModels()),
            //Атрибуты
            "depth" => [
                "@type" => "QuantitativeValue",
                "unitCode" => "CMT",
                "value" => $product->dimensions->depth
            ],
            "width" => [
                "@type" => "QuantitativeValue",
                "unitCode" => "CMT",
                "value" => $product->dimensions->width
            ],
            "height" => [
                "@type" => "QuantitativeValue",
                "unitCode" => "CMT",
                "value" => $product->dimensions->height
            ],
            "weight" => [
                "@type" => "QuantitativeValue",
                "unitCode" => "KGM",
                "value" => $product->dimensions->weight
            ],
            //TODO Серия и Цвета

            'model' => is_null($product->series) ? null : [
                "@type" => "ProductModel",
                "name" => $product->series->name,
                "aggregateRating" => ["@type" => "aggregateRating", "ratingValue" => "5", "ratingCount" => "70"]
            ],
            'isSimilarTo' => is_null($product->equivalent) ? null : array_map(function (Product $product) {
                return [
                    "@type" => "Product",
                    "name" => $product->name,
                    "mainEntityOfPage" => route('shop.product.view', $product->slug),
                    "sku" => $product->code,
                ];
            },
                $product->equivalent->products()->where('published', true)->getModels()),

            //TODO Отзывы

            //TODO Рейтинг - на основе отзывов

            'offers' => $this->_Offer($product),
        ];
    }

    private function _SubCategories(Category $category)
    {
        $list = array_map(function (Category $category) {
            return [
                "@type" => "CollectionPage",
                "mainEntityOfPage" => route('shop.category.view', $category->slug),
                "name" => $category->name,
            ];
        },
            $category->children()->getModels()
        );

        return $this->_CollectionPage($list, $category);
    }

    private function _Products(Category $category)
    {
        $list = array_map(function (Product $product) {
            return [

                "@type" => "Product",
                "mainEntityOfPage" => route('shop.product.view', $product->slug),
                "url" => route('shop.product.view', $product->slug),
                "name" => $product->name,
                "image" => is_null($product->photo) ? $product->getImage() : $product->photo->getThumbUrl('card'),
                "description" => strip_tags($product->description),
                "Offers" => [
                    "@type" => "Offer",
                    "price" => $product->getLastPrice(),
                    "priceCurrency" => "RUB",
                    "availability" => "https://schema.org/" . ($product->getCountSell() == 0 ? 'InStock' : 'PreOrder'),
                ],
            ];
        },
            $category->products()->where('published', true)->getModels()
        );
        return $this->_CollectionPage($list, $category);
    }

    private function _CollectionPage(array $list, Category $category)
    {
        return [
            "@context" => "https://schema.org",
            "@type" => "CollectionPage",
            "url" => $this->url,
            "datePublished" => now(),
            "dateModified" => now(),
            "description" => "",
            "inLanguage" => "ru-RU",
            "potentialAction" => [
                "@type" => "SearchAction",
                "target" => [
                    "@type" => "EntryPoint",
                    "urlTemplate" => $this->url . "/search?q={search_term_string}",
                ],
                "query-input" => "required name=search_term_string"
            ],
            "provider" => $this->_Organization(),
            "breadcrumb" => ["@id" => "breadcrumb"],
            "mainEntity" => [
                "@type" => "ItemList",
                "numberOfItems" => count($list),
                "itemListOrder" => "https://schema.org/ItemListOrderDescending",
                "name" => "Товары и подкатегории " . $category->name,
                "itemListElement" => $list,
            ],
        ];
    }

*/
}
