<?php

namespace App\Livewire\Pages;

use App\Models\Setting;
use Livewire\Component;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Converter;

class RequisitesPage extends Component
{
    public $settings = [];

    public function mount()
    {
        $this->settings = Setting::getByPrefix('org');
    }

    public function downloadDocx()
    {
        $phpWord = new PhpWord();

        // Добавляем секцию
        $section = $phpWord->addSection();

        $section->addText(
            'Реквизиты ' . (setting('org_short_name') ?? 'Организации'),
            ['bold' => true, 'size' => 16],
            ['alignment' => 'center', 'spaceAfter' => 300]
        );

        $section->addText(
            'Сформировано: ' . now()->format('d.m.Y H:i'),
            ['size' => 10, 'color' => '666666'],
            ['alignment' => 'right', 'spaceAfter' => 200]
        );

        // Таблица с реквизитами
        $table = $section->addTable([
            'borderSize' => 6,
            'borderColor' => '000000',
            'cellMargin' => 80,
        ]);


        $requisites = $this->settings->toArray();

        // Заполняем таблицу
        foreach ($requisites as $requisite) {
            $table->addRow();

            // Название реквизита
            $table->addCell(Converter::cmToTwip(5))
                ->addText($requisite['description'], ['bold' => true], ['valign' => 'center']);

            // Значение реквизита
            $table->addCell(Converter::cmToTwip(10))
                ->addText($requisite['value'], null, ['valign' => 'center']);
        }

        // Сохраняем файл
        $fileName = 'requisites_' . ($this->settings['org_short_name'] ?? 'organization') . '_' . date('Y-m-d') . '.docx';
        $tempFile = storage_path('app/temp/' . $fileName);

        // Создаем директорию если нет
        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($tempFile);

        // Возвращаем файл для скачивания
        return response()->download($tempFile)->deleteFileAfterSend(true);
    }

    public function render()
    {
        return view('livewire.requisites-page');
    }
}
