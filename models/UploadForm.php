<?php
/**
 * Created by PhpStorm.
 * User: SERG
 * Date: 10.03.2017
 * Time: 21:32
 */

namespace app\models;

use app\packages\upload\FileInfo;
use app\packages\upload\FilesInfo;
use PHPExcel_Shared_Date;
use Yii;
use yii\base\Model;
use yii\db\IntegrityException;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $xlsFile;
    public $uploadedFileInfo;
    private $allowedExt = ['xls', 'xlsx'];

    const LOAD_ERROR = "Ошибка при загрузке файла";
    const INCORRECT_FILE_FORMAT_ERROR = "Неправильный формат файла";
    const EMPTY_FILE_ERROR = "Файл пустой";
    const PARSING_ERROR = "Ошибка при разборе файла";
    const NO_DATA_ERROR = "Файл не содержит данных";
    const SAVE_ERROR = "Ошибка при сохранении в базу данных";
    const DATA_EXISTS = "Данные с таким ключом уже добавлены";

    public function parseAndSaveData()
    {
        $fileName = $this->xlsFile->baseName . '.' . $this->xlsFile->extension;
        $errorText = "";
        if ($this->xlsFile->error != 0){
            $errorText = self::LOAD_ERROR;
        }
        elseif (!in_array($this->xlsFile->extension, $this->allowedExt)){
            $errorText = self::INCORRECT_FILE_FORMAT_ERROR;
        }
        elseif ($this->xlsFile->size == 0){
            $errorText = self::EMPTY_FILE_ERROR;
        }
        else {
            $xlsDataObjects = [];

            try {
                $xlsDataObjects = $this->xlsParse();
                if (count($xlsDataObjects) == 0)
                    $errorText = self::NO_DATA_ERROR;
            } catch (\Exception $e) {
                $errorText = self::PARSING_ERROR;
            }


            try {
                foreach ($xlsDataObjects as $xlsDataObj)
                    $xlsDataObj->save();
            }
            catch(IntegrityException $e)
            {
                $errorText = self::DATA_EXISTS;
            }
            catch (\Exception $e) {
                $errorText = self::SAVE_ERROR;
            }
        }
        $this->uploadedFileInfo  = new FileInfo($fileName, $errorText);
    }

    private function xlsParse()
    {
        $xlsDataObjects = [];
        $inputFileType = \PHPExcel_IOFactory::identify($this->xlsFile->tempName);
        $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($this->xlsFile->tempName);
        $sheet = $objPHPExcel->getSheet(0);
        $maxRow = $sheet->getHighestRow();
        $maxCol = $sheet->getHighestColumn();
        if ($maxCol != 'D')
            throw new \Exception("Incorrect number of columns");

        for ($row = 2; $row <= $maxRow; $row++) {
            $rowData = $sheet->rangeToArray("A$row:$maxCol$row", null, true, false)[0];

            $xlsData = new XlsData();
            $xlsData->name = (string)$rowData[0];
            $xlsData->id = (int)$rowData[1];
            $xlsData->parent_id = (int)$rowData[2];

            $date = \Datetime::createFromFormat('d.m.Y', (string)$rowData[3]);
            if (!$date)
                $date = PHPExcel_Shared_Date::ExcelToPHPObject($rowData[3]);
            $xlsData->date = $date->format('Y-m-d');
            $xlsDataObjects[] = $xlsData;
        }
        return $xlsDataObjects;
    }
}