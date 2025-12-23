<?php

namespace App\Livewire\Pages\Multi\Order;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Support\Collection;
use Livewire\Component;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Converter;

class OrderItemsPage extends Component
{
    public Order $order;
    public Collection $orderItems;

    public function mount(int $id)
    {
        $this->order = Order::query()->find($id);
        $this->orderItems = $this->order->orderItems;
    }

    public function downloadScore()
    {
        $score = [
            // Данные клиента
            'clientName'     => auth()->user()->client->name,
            'clientInn'      => auth()->user()->client->inn,
            'clientAddress'  => auth()->user()->client->address,
            'clientPhone'    => auth()->user()->client->phone,
            'clientEmail'    => auth()->user()->email,

            // Данные заказа
            'orderNumber'    => $this->order->id,
            'orderDate'      => $this->order->created_at,
            'orderItems'     => $this->order->orderItems,
            'orderTotal'     => $this->order->totalAmount,

            'ownName'        => setting('org_full_name'),
            'ownInn'         => setting('org_inn'),
            'ownKpp'         => setting('org_kpp'),
            'ownBank'        => setting('org_bank_name'),
            'ownBik'         => setting('org_bik'),
            'ownAccount'     => setting('org_payment_account'),
            'ownCorrAccount' => setting('org_correspondent_account'),
            'ownAddress'     => setting('org_legal_address'),
            'ownPhone'       => setting('org_phone'),
        ];

        $phpWord = new PhpWord();

        // Настройки страницы
        $section = $phpWord->addSection([
            'marginLeft'   => Converter::cmToTwip(2),
            'marginRight'  => Converter::cmToTwip(1.5),
            'marginTop'    => Converter::cmToTwip(2),
            'marginBottom' => Converter::cmToTwip(2),
        ]);

        // ШАПКА СЧЁТА
        $section->addText(
            "СЧЁТ № {$score['orderNumber']} от {$score['orderDate']}",
            ['bold' => true, 'size' => 14],
            ['alignment' => 'center', 'spaceAfter' => 300]
        );

        // ТАБЛИЦА: Поставщик и Плательщик
        $infoTable = $section->addTable([
            'borderSize' => 1,
            'borderColor' => '000000',
            'cellMargin' => 50,
        ]);

        // Поставщик
        $infoTable->addRow();
        $infoTable->addCell(Converter::cmToTwip(8))
            ->addText("Поставщик:\n" . $score['ownName'] . "\nИНН " . $score['ownInn'] .
                ($score['ownKpp'] ? " КПП " . $score['ownKpp'] : "") . "\n" .
                $score['ownAddress'] . "\nТел.: " . $score['ownPhone'],
                null, ['alignment' => 'left']);

        // Плательщик
        $infoTable->addCell(Converter::cmToTwip(8))
            ->addText("Плательщик:\n" . $score['clientName'] . "\nИНН " . $score['clientInn'] .
                "\n" . $score['clientAddress'] . "\nТел.: " . $score['clientPhone'],
                null, ['alignment' => 'left']);

        $section->addTextBreak(1);

        // РЕКВИЗИТЫ ДЛЯ ОПЛАТЫ
        $section->addText("Банковские реквизиты для оплаты:", ['bold' => true], ['spaceAfter' => 100]);

        $bankTable = $section->addTable(['borderSize' => 0]);
        $bankTable->addRow();
        $bankTable->addCell(3000)->addText("Банк:", ['bold' => true]);
        $bankTable->addCell(8000)->addText($score['ownBank']);

        $bankTable->addRow();
        $bankTable->addCell(3000)->addText("БИК:", ['bold' => true]);
        $bankTable->addCell(8000)->addText($score['ownBik']);

        $bankTable->addRow();
        $bankTable->addCell(3000)->addText("Расчётный счёт:", ['bold' => true]);
        $bankTable->addCell(8000)->addText($score['ownAccount']);

        $bankTable->addRow();
        $bankTable->addCell(3000)->addText("Корр. счёт:", ['bold' => true]);
        $bankTable->addCell(8000)->addText($score['ownCorrAccount']);

        $section->addTextBreak(1);

        // ТАБЛИЦА ТОВАРОВ
        $section->addText("Перечень товаров (работ, услуг):", ['bold' => true], ['spaceAfter' => 100]);

        $productsTable = $section->addTable([
            'borderSize' => 1,
            'borderColor' => '000000',
            'cellMargin' => 50,
        ]);

        // Заголовки таблицы
        $productsTable->addRow();
        $productsTable->addCell(800)->addText('№', ['bold' => true], ['alignment' => 'center', 'valign' => 'center']);
        $productsTable->addCell(4000)->addText('Наименование товара', ['bold' => true], ['alignment' => 'center', 'valign' => 'center']);
        $productsTable->addCell(1500)->addText('Кол-во', ['bold' => true], ['alignment' => 'center', 'valign' => 'center']);
        $productsTable->addCell(2000)->addText('Цена', ['bold' => true], ['alignment' => 'center', 'valign' => 'center']);
        $productsTable->addCell(2000)->addText('Сумма', ['bold' => true], ['alignment' => 'center', 'valign' => 'center']);

        // Товары
        $totalSum = 0;
        foreach ($score['orderItems'] as $index => $item) {
            $quantity = $item->quantity ?? 1;
            $price = $item->price ?? $item->unit_price ?? 0;
            $sum = $quantity * $price;
            $totalSum += $sum;

            $productsTable->addRow();
            $productsTable->addCell(800)->addText($index + 1, null, ['alignment' => 'center', 'valign' => 'center']);
            $productsTable->addCell(4000)->addText($item->product->name ?? $item->product_name ?? 'Товар');
            $productsTable->addCell(1500)->addText($quantity . ' шт.', null, ['alignment' => 'center', 'valign' => 'center']);
            $productsTable->addCell(2000)->addText(number_format($price, 2, ',', ' ') . ' ₽', null, ['alignment' => 'right', 'valign' => 'center']);
            $productsTable->addCell(2000)->addText(number_format($sum, 2, ',', ' ') . ' ₽', null, ['alignment' => 'right', 'valign' => 'center']);
        }

        // ИТОГО
        $productsTable->addRow();
        $productsTable->addCell(6300, ['bgColor' => 'E6E6E6'])->addText('Итого:', ['bold' => true], ['alignment' => 'right', 'valign' => 'center']);
        $productsTable->addCell(2000, ['bgColor' => 'E6E6E6'])->addText($score['orderTotal'] . ' ₽', ['bold' => true], ['alignment' => 'right', 'valign' => 'center']);

        $section->addTextBreak(1);

        // СУММА ПРОПИСЬЮ
        $section->addText(
            "Всего к оплате: " . $score['orderTotal'],
            ['italic' => true],
            ['spaceAfter' => 200]
        );

        // НДС (если есть)
        if (setting('org_with_vat', false)) {
            $vatRate = setting('org_vat_rate', 20);
            $vatAmount = $this->order->totalAmount * $vatRate / 100;

            $section->addText(
                "В том числе НДС {$vatRate}%: " . number_format($vatAmount, 2, ',', ' ') . ' ₽',
                null,
                ['spaceAfter' => 100]
            );
        } else {
            $section->addText(
                "Без налога (НДС)",
                null,
                ['spaceAfter' => 100]
            );
        }

        // ПОДПИСИ
        $signatureTable = $section->addTable(['borderSize' => 0]);

        $signatureTable->addRow();

        // СОХРАНЕНИЕ
        $fileName = "Счёт_№{$score['orderNumber']}_от_{$score['orderDate']}.docx";
        $fileName = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '_', $fileName);

        $tempFile = storage_path('app/temp/' . $fileName);

        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($tempFile);

        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }

    public function render()
    {
        return view('livewire.pages.multi.order.order-items-page');
    }
}
