<?php

namespace App\Livewire\Pages\Multi\Catalog;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductSubstitution;
use App\Models\WarehouseProduct;
use Illuminate\Support\Collection;
use Livewire\Component;

class ProductPage extends Component
{
    public Product $product;

    public Collection $products;
    public Collection $filteredProducts;
    public ?Cart $cart;

    public array $selectedManufacturers = [];
    public array $selectedWarehouseTypes = [];
    public bool $inStockOnly = false;
    public bool $onSaleOnly = false;
    public ?float $minPrice = 0;
    public ?float $maxPrice = 0;
    public string $sortBy = '';

    // Производители
    public Collection $manufacturers;

    // Счетчики
    public int $totalCount = 0;
    public int $filteredCount = 0;


    public function mount(string $slug)
    {
        $this->product = Product::query()
            ->firstWhere('sku', $slug);
        $this->cart = Cart::query()
            ->firstWhere('user_id', auth()->id());

        $this->addBreadcrumbs();

        $this->loadProducts();
        $this->loadManufacturers();
    }

    public function loadProducts()
    {
        $products = $this->product->warehouseProducts->map(function (WarehouseProduct $warehouseProduct) {
            return [
                'id' => $warehouseProduct->product->id,
                'warehouseProduct' => $warehouseProduct->id,
                'name' => $warehouseProduct->product->name,
                'price' => $this->product->cleanPrice,
                'sku'   => $this->product->sku,
                'warehouse' => $warehouseProduct->warehouse,
                'quantity' => $warehouseProduct->quantity,
                'manufacturer' => $this->product->manufacturer,
                'minOrderQuantity' => $this->product->min_order_quantity,
                'in_cart' => $this->cart?->cartItems()->where('warehouse_product_id', $warehouseProduct->id)->exists() ?? false,
                'type' => 'main'
            ];
        });

        $productSubstitutions = $this->product->productSubstitutions
            ->filter(function (ProductSubstitution $productSubstitution) {
                return !$productSubstitution->substitute->warehouseProducts->isEmpty();
            })
            ->flatMap(function (ProductSubstitution $productSubstitution) {
                $substitute = $productSubstitution->substitute;

                return $substitute->warehouseProducts->map(function (WarehouseProduct $warehouseProduct) use ($substitute) {
                    return [
                        'id' => $substitute->id,
                        'warehouseProduct' => $warehouseProduct->id,
                        'name' => $substitute->name,
                        'price' => $substitute->productPrices()->first()->cleanPrice,
                        'sku'   => $substitute->sku,
                        'warehouse' => $warehouseProduct->warehouse,
                        'quantity' => $warehouseProduct->quantity,
                        'manufacturer' => $substitute->manufacturer,
                        'minOrderQuantity' => $substitute->min_order_quantity,
                        'in_cart' => $this->cart?->cartItems()->where('warehouse_product_id', $warehouseProduct->id)->exists() ?? false,
                        'type' => 'substitute'
                    ];
                });
            });

        $this->products = $products->merge($productSubstitutions);
        $this->totalCount = $this->products->count();
    }

    public function loadManufacturers()
    {
        $this->manufacturers = $this->products
            ->unique('manufacturer')
            ->map(function ($item) {
                return [
                    'id' => $item['manufacturer']->id,
                    'name' => $item['manufacturer']->name,
                    'price' => $this->products->where('warehouse', $item['warehouse'])->min('price')
                ];
            })
            ->sortBy('name')
            ->values();
    }

//    public function calculatePriceRange()
//    {
//        if ($this->products->isNotEmpty()) {
//            $this->priceMin = $this->products->min('price');
//            $this->priceMax = $this->products->max('price');
//
//            // Устанавливаем начальные значения
//            $this->minPrice = $this->priceMin;
//            $this->maxPrice = $this->priceMax;
//        }
//    }

    public function applyFilters()
    {
//        dd($this->minPrice, $this->maxPrice);
    }

    public function addToCart(int $id)
    {
        $warehouseProduct = WarehouseProduct::query()->find($id);

        $cart = Cart::query()->firstOrCreate([
            'user_id' => auth()->id(),
        ]);

        $cart->cartItems()->create([
            'warehouse_product_id' => $id,
            'quantity' => 1,
            'price' => $warehouseProduct->product->cleanPrice * 100,
        ]);

        $this->dispatch('showToast',
            type: 'success',
            message: 'Товар добавлен в корзину'
        );
    }

    public function addBreadcrumbs(): void
    {
        $this->dispatch('updateBreadcrumbs',
            items: [
                [
                    'label' => 'Каталог',
                    'url' => route('catalog'),
                    'active' => false
                ],
                [
                    'label' => $this->product->name,
                    'url' => 'javascript:void(0)',
                    'active' => true
                ],
            ]
        );
    }

    public function render()
    {
        return view('livewire.pages.multi.catalog.product-page');
    }
}
