<?php
/**
 * This file export data
 */
namespace App\Pmo\Library\ProcessData;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Export
{
    public static $filename = 'File export';
    public static $sheetname = 'Sheet name';
    public static $title = '';

    public static function export($type = "xls", $dataExport = [], $options = [])
    {
        switch ($type) {
            case 'xls':
                return self::exportExcel($dataExport, $options);
                break;
            case 'invoice_excel':
                return self::exportInvoice($dataExport, $options);
                break;
            default:
                # code...
                break;
        }
    }

    public static function exportExcel($dataExport = [], $options = [])
    {
        $filename = $options['filename'] ?? self::$filename;
        $sheetname = $options['sheetname'] ?? self::$sheetname;
        $title = $options['title'] ?? self::$title;
        $row = empty($title) ? 1 : 2;
        $spreadsheet = new Spreadsheet();
        $worksheet = $spreadsheet->getActiveSheet();
        $worksheet->setTitle($sheetname);
        if ($row == 2) {
            $worksheet->getCell('A1')->setValue($title);
        }
        $worksheet->fromArray($dataExport, $nullValue = null, $startCell = 'A' . $row);
        $writer = IOFactory::createWriter($spreadsheet, "Xlsx");
        // $writer->save('write.xls');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');
        $writer->save("php://output");
    }

    public static function exportInvoice($dataExport = [], $options = [])
    {
        
        $filename = $options['filename'] ?? self::$filename;
        $sheetname = $options['sheetname'] ?? self::$sheetname;
        $title = $options['title'] ?? self::$title;
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
        if (file_exists(resource_path('views/vendor/s-pmo-admin/format/export/invoice.xlsx'))) {
            $spreadsheet = $reader->load(resource_path('views/vendor/s-pmo-admin/format/export/invoice.xlsx'));
        } else {
            $spreadsheet = $reader->load(base_path('vendor/s-pmo/core/src/Views/admin/format/export/invoice.xlsx'));
        }
        $worksheet = $spreadsheet->getActiveSheet();
        // $worksheet->getDefaultColumnDimension()->setWidth(100);
        $worksheet->setTitle($sheetname);
        $worksheet->getCell('E1')->setValue(sc_language_render('order.date_export'));
        $worksheet->getCell('E2')->setValue(date('Y-m-d'));
        $worksheet->getCell('F1')->setValue(sc_language_render('order.id'));
        $worksheet->getCell('F2')->setValue($dataExport['id']);
        //logo
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooterDrawing();
        $drawing->setName('Store logo');
        $drawing->setPath(public_path(sc_store('logo')));
        $drawing->setHeight(50);
        $drawing->setCoordinates('A1');
        $drawing->setOffsetX(5);
        $drawing->setOffsetY(5);
        $drawing->setRotation(25);
        $drawing->getShadow()->setVisible(true);
        $drawing->getShadow()->setDirection(45);
        $drawing->setWorksheet($worksheet);
        //End logo

        $indexRow = 2;
        $worksheet->getCell('A' . $indexRow)->setValue(sc_language_render('order.full_name') . ':')
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell('B' . $indexRow)->setValue($dataExport['name']);

        ++$indexRow;
        $worksheet->insertNewRowBefore($indexRow, 1);
        $worksheet->getCell('A' . $indexRow)->setValue(sc_language_render('order.shipping_address') . ':')
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell('B' . $indexRow)->setValue($dataExport['address']);

        ++$indexRow;
        $worksheet->insertNewRowBefore($indexRow, 1);
        $worksheet->getCell('A' . $indexRow)->setValue(sc_language_render('order.shipping_phone') . ':')
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell('B' . $indexRow)->setValue($dataExport['phone']);

        ++$indexRow;
        $worksheet->insertNewRowBefore($indexRow, 1);
        $worksheet->getCell('A' . $indexRow)->setValue(sc_language_render('order.email') . ':')
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell('B' . $indexRow)->setValue($dataExport['email']);

        ++$indexRow;
        $worksheet->insertNewRowBefore($indexRow, 1);
        $worksheet->getCell('A' . $indexRow)->setValue(sc_language_render('order.payment_method') . ':')
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell('B' . $indexRow)->setValue($dataExport['payment_method']);

        ++$indexRow;
        $worksheet->insertNewRowBefore($indexRow, 1);
        $worksheet->getCell('A' . $indexRow)->setValue(sc_language_render('order.shipping_method') . ':')
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell('B' . $indexRow)->setValue($dataExport['shipping_method']);

        ++$indexRow;
        $worksheet->insertNewRowBefore($indexRow, 1);
        $worksheet->getCell('A' . $indexRow)->setValue(sc_language_render('order.date') . ':')
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell('B' . $indexRow)->setValue($dataExport['created_at']);

        ++$indexRow;
        $worksheet->insertNewRowBefore($indexRow, 1);
        $worksheet->getCell('A' . $indexRow)->setValue(sc_language_render('order.currency') . ':')
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell('B' . $indexRow)->setValue($dataExport['currency']);

        ++$indexRow;
        $worksheet->insertNewRowBefore($indexRow, 1);
        $worksheet->getCell('A' . $indexRow)->setValue(sc_language_render('order.exchange_rate') . ':')
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell('B' . $indexRow)->setValue($dataExport['exchange_rate']);

        //Title product detail
        $indexTitleRowDetail = $indexRow + 2;
        $worksheet->getCell('B' . $indexTitleRowDetail)->setValue(sc_language_render('product.sku'));
        $worksheet->getCell('C' . $indexTitleRowDetail)->setValue(sc_language_render('product.name'));
        $worksheet->getCell('D' . $indexTitleRowDetail)->setValue(sc_language_render('order.qty'));
        $worksheet->getCell('E' . $indexTitleRowDetail)->setValue(sc_language_render('order.amount'));
        $worksheet->getCell('F' . $indexTitleRowDetail)->setValue(sc_language_render('order.totals.total'));

        //Item detail
        $indexRowDetail = $indexRow + 3;
        if ($dataExport['details']) {
            foreach ($dataExport['details'] as $key => $detail) {
                $worksheet->fromArray($detail, $nullValue = null, $startCell = 'A' . $indexRowDetail);
                if (count($dataExport['details']) > ($key + 1)) {
                    ++$indexRowDetail;
                    $worksheet->insertNewRowBefore($indexRowDetail, 1);
                }
            }
        }
        //Subtotal
        $indexRowTotal = $indexRowDetail + 1;
        $worksheet->getCell('E' . $indexRowTotal)->setValue(sc_language_render('order.totals.subtotal').':');
        $worksheet->getCell('F' . $indexRowTotal)->setValue($dataExport['subtotal']);
        //Tax
        ++$indexRowTotal;
        $worksheet->getCell('E' . $indexRowTotal)->setValue(sc_language_render('order.totals.tax').':');
        $worksheet->getCell('F' . $indexRowTotal)->setValue($dataExport['tax']);
        //Shipping
        ++$indexRowTotal;
        $worksheet->getCell('E' . $indexRowTotal)->setValue(sc_language_render('order.totals.shipping').':');
        $worksheet->getCell('F' . $indexRowTotal)->setValue($dataExport['shipping']);
        //Discount
        ++$indexRowTotal;
        $worksheet->getCell('E' . $indexRowTotal)->setValue(sc_language_render('order.totals.discount').':');
        $worksheet->getCell('F' . $indexRowTotal)->setValue($dataExport['discount']);
        //Total
        ++$indexRowTotal;
        $worksheet->getCell('E' . $indexRowTotal)->setValue(sc_language_render('order.totals.total').':');
        //Other
        ++$indexRowTotal;
        $worksheet->getCell('E' . $indexRowTotal)->setValue(sc_language_render('order.other_fee').':');
        $worksheet->getCell('F' . $indexRowTotal)->setValue($dataExport['other_fee'] ?? 0);
        //Received
        ++$indexRowTotal;
        $worksheet->getCell('E' . $indexRowTotal)->setValue(sc_language_render('order.totals.received').':');
        $worksheet->getCell('F' . $indexRowTotal)->setValue($dataExport['received']);
        //Balance
        ++$indexRowTotal;
        $worksheet->getCell('E' . $indexRowTotal)->setValue(sc_language_render('order.totals.balance').':');

        // $worksheet->fromArray($dataExport, $nullValue = null, $startCell = 'A' . $row);
        $writer = IOFactory::createWriter($spreadsheet, "Xlsx");
        // $writer->save('write.xls');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');
        $writer->save("php://output");
    }
}
