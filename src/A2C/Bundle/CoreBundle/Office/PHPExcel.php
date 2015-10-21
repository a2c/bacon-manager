<?php

namespace A2C\Bundle\CoreBundle\Office;

use Symfony\Component\HttpFoundation\StreamedResponse;
use \PHPExcel as PHPOfficeExcel;
use \PHPExcel_IOFactory;
use \PHPExcel_Worksheet_PageSetup;
use \PHPExcel_Style_Border;
use \PHPExcel_Style_Fill;
use \PHPExcel_Style_Alignment;

/**
 * Cria relatórios utilizando a biblioteca PHPExcel
 *
 * @version 0.1
 */
class PHPExcel
{
    const DOCUMENT_CREATED_BY = 'A2C';

    /**
     * @var PHPExcel
     */
    protected $phpExcel;

    /**
     * @var array
     */
    protected $data;

    /**
     * @var array
     */
    protected $header;

    /**
     * Start
     *
     * @param string $headerTitle título do documento
     * @param string $activeSheetTitle título da planilha (aba)
     */
    public function __construct($headerTitle, $activeSheetTitle = null)
    {
        $this->phpExcel = new PHPOfficeExcel();

        $this->getPhpExcel()->getProperties()
            ->setTitle($headerTitle)
            ->setCreator(self::DOCUMENT_CREATED_BY)
            ->setLastModifiedBy(self::DOCUMENT_CREATED_BY)
        ;

        $this->getPhpExcel()->setActiveSheetIndex(0);

        $this->getPhpExcel()->getActiveSheet()->setTitle(is_null($activeSheetTitle) ? $headerTitle : $activeSheetTitle);

        $this->getPhpExcel()->getActiveSheet()->getPageSetup()
            ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE)
            ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4)
        ;
    }

    /**
     * Cria um objeto Response
     *
     * @param  string $writer
     * @return StreamedResponse
     */
    public function createResponse($writer = 'Excel5')
    {
        $objWriter = PHPExcel_IOFactory::createWriter($this->getPhpExcel(), $writer);

        $response = new StreamedResponse(function() use ($objWriter) {

            echo $objWriter->save('php://output');
        });

        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=relatorio.xls');

        return $response;
    }

    /**
     * Build
     *
     * @return void
     */
    public function build()
    {
        $activeSheet = $this->getPhpExcel()->getActiveSheet();

        $header = $this->getHeader();
        $data = $this->getData();
        $columnNames = $this->getColumnNames();

        $qtdColumns = count($header);
        $lastColumnName = '';

        for ($index = 0; $index < $qtdColumns; $index++) {

            $lastColumnName = $columnNames[$index];

            $activeSheet->getColumnDimension($lastColumnName)->setAutoSize(true);
        }

        // ------------------------------------------------------------------------------
        // Titles

        $activeSheet->mergeCells(sprintf('A1:%s1', $lastColumnName));
        $activeSheet->mergeCells(sprintf('A2:%s2', $lastColumnName));

        $activeSheet->getStyle(sprintf('A1:%s1', $lastColumnName))->applyFromArray($this->getStyle('title'));
        $activeSheet->getStyle(sprintf('A2:%s2', $lastColumnName))->applyFromArray($this->getStyle('created'));
        $activeSheet->getStyle(sprintf('A3:%s3', $lastColumnName))->applyFromArray($this->getStyle('header'));

        $activeSheet->getRowDimension(1)->setRowHeight($this->getRowHeight() * 2 + ($this->getRowHeight() / 2));
        $activeSheet->getRowDimension(2)->setRowHeight($this->getRowHeight());
        $activeSheet->getRowDimension(3)->setRowHeight($this->getRowHeight() + ($this->getRowHeight() / 2));

        $activeSheet->setCellValue('A1', $this->getPhpExcel()->getProperties()->getTitle());

        $activeSheet->setCellValue('A2', sprintf('%s %s às %s', 'Exportado em', date('d/m/Y'), date('H:i:s')));

        // ------------------------------------------------------------------------------
        // Header

        $columnNumber = 0;

        foreach ($header as $key => $value) {

            $activeSheet->setCellValueByColumnAndRow($columnNumber++, 3, $value);
        }

        // ------------------------------------------------------------------------------
        // Registros

        foreach ($data as $lineNumber => $row) {

            $columnNumber = 0;

            $activeSheet->getRowDimension($lineNumber + 4)->setRowHeight($this->getRowHeight());

            $activeSheet->getStyle(sprintf('A%s:%s%s', $lineNumber + 4, $lastColumnName, $lineNumber + 4))->applyFromArray($this->getStyle('row'));

            foreach ($header as $key => $value) {

                if ($row[$key] instanceof \DateTime) {
                    $row[$key] = $row[$key]->format('d/m/Y H:i:s');
                }

                $activeSheet->setCellValueByColumnAndRow($columnNumber, $lineNumber + 4, $row[$key]);

                $columnNumber++;
            }
        }
    }

    /**
     * Altura das células
     *
     * @return int
     */
    public function getRowHeight()
    {
        return 30;
    }

    /**
     * Gets the value of phpExcel.
     *
     * @return PHPOfficeExcel
     */
    public function getPhpExcel()
    {
        return $this->phpExcel;
    }

    /**
     * Gets the value of data.
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Sets the value of data.
     *
     * @param mixed $data the data
     *
     * @return self
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Gets the value of header.
     *
     * @return mixed
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * Sets the value of header.
     *
     * @param mixed $header the header
     *
     * @return self
     */
    public function setHeader($header)
    {
        $this->header = $header;

        return $this;
    }

    /**
     * Gets the value of columns names.
     *
     * @return array
     */
    protected function getColumnNames()
    {
        return array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'X', 'Y', 'Z');
    }

    /**
     * Template
     *
     * @param string $name o nome do template
     *
     * @return array
     */
    public function getStyle($name)
    {
        $styles = array(
            'title' => array(
                'font' => array(
                    'name' => 'Arial',
                    'size' => 14,
                    'bold' => true,
                    'color' => array(
                        'rgb' => '000000'
                    ),
                ),
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array(
                            'rgb' => '808080'
                        )
                    ),
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                        'rgb' => 'eeeeee',
                    ),
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                ),
            ),
            'created' => array(
                'font' => array(
                    'name' => 'Arial',
                    'size' => 10,
                    'bold' => false,
                    'italic' => true,
                    'color' => array(
                        'rgb' => '000000'
                    ),
                ),
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array(
                            'rgb' => '808080'
                        )
                    ),
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                        'rgb' => 'eeeeee',
                    ),
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                ),
            ),
            'header' => array(
                'font' => array(
                    'name' => 'Arial',
                    'size' => 13,
                    'bold' => true,
                    'color' => array(
                        'rgb' => '000000'
                    ),
                ),
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array(
                            'rgb' => '808080'
                        )
                    ),
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                        'rgb' => 'eeeeee',
                    ),
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                ),
            ),
            'row' => array(
                'font' => array(
                    'name' => 'Arial',
                    'size' => 12,
                    'color' => array(
                        'rgb' => '000000'
                    ),
                ),
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array(
                            'rgb' => '808080'
                        )
                    ),
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                        'rgb' => 'ffffff',
                    ),
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                ),
            ),
        );

        return $styles[$name];
    }
}
