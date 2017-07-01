<?php

namespace app\controllers;

use app\models\Account;
use app\models\Category;
use app\models\Settings;
use app\models\Transaction;
use app\models\User;
use app\repositories\TransactionsRepository;
use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Settings;
use PHPExcel_Style_Border;
use PHPExcel_Style_NumberFormat;
use PhpImap\Mailbox;
use Yii;
use yii\console\Controller;

class SendController extends Controller
{
    public function actionSend($login)
    {
        $fileName = '/var/www/homefinance/excel/weekReport';

        /** @var User $user */
        $user = User::find()
            ->where(['login' => $login])
            ->one();
        $email = $user->email;
        $monday = date('Y-m-d H:i:s', strtotime('Monday previous week'));
        $sunday = date('Y-m-d 23:59:59', strtotime('Sunday previous week'));
        $trans = new TransactionsRepository();
        $trans->startDate = $monday;
        $trans->finishDate = $sunday;
        $transactionsList = $trans->consolidateTransaction($login);

        $phpExcel = new PHPExcel();
        $phpExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $phpExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $phpExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $phpExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);

        $heightOfTable = count($transactionsList) + 1;
        $phpExcel->getActiveSheet()->getStyle('A1:D' . $heightOfTable)
            ->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $phpExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'Date');
        $phpExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, 'Amount');
        $phpExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 1, 'Category');
        $phpExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 1, 'Type');
        $phpExcel->getActiveSheet()
            ->getStyle('A2:A' . $heightOfTable)
            ->getNumberFormat()
            ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);

        $i = 2;
        foreach ($transactionsList as $item) {
            $phpExcel->getActiveSheet()
                ->setCellValueByColumnAndRow(0, $i, date_create($item->date)
                    ->format('d/m/Y'));
            $phpExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i, $item->summ);
            $phpExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i, $item->category);
            $phpExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $i, $item->type);
            $i++;
        }
        $phpExcel->getActiveSheet()->setTitle("Week report");

        $group = Settings::getGroup('letter');
        $letterText = $letterText = $group->data;

        if ($letterText['type'] == 'pdf') {
            PHPExcel_Settings::setPdfRenderer(
                PHPExcel_Settings::PDF_RENDERER_TCPDF,
                '/var/www/homefinance/vendor/tecnickcom/tcpdf'
            );

            $objWriter = PHPExcel_IOFactory::createWriter($phpExcel, 'PDF');
            $fileName .= '.pdf';
            $objWriter->save($fileName);
        } elseif ($letterText['type'] == 'excel') {
            $objWriter = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel2007');
            $fileName .= '.xlsx';
            $objWriter->save($fileName);
        }

        Yii::$app->mailer->compose()
            ->setFrom('sasintimur@yandex.ru')
            ->setTo($email)
            ->setSubject($letterText['subject'])
            ->setHtmlBody($letterText['text'])
            ->attach($fileName)
            ->send();
        unlink($fileName);
    }

    public function actionMail()
    {
        $imapPath = Yii::$app->params['mailbox']['imapPath'];
        $login = Yii::$app->params['mailbox']['login'];
        $password = Yii::$app->params['mailbox']['password'];
        $mailbox = new Mailbox($imapPath, $login, $password);

        $mailsIds = $mailbox->searchMailbox('UNSEEN');
        if (!$mailsIds) {
            Yii::$app->end();
        }

        foreach ($mailsIds as $key => $value) {
            $mail = $mailbox->getMail($mailsIds[$key]);
            $text = null;

            if (!$this->checkSender($mail)) {
                continue;
            }

            $text = $this->parseMailBody($mail->textPlain);

            if (!$this->checkMailText($text, $mail)) {
                continue;
            }

            $transaction = new Transaction();
            $transaction->login = $mail->subject;
            $transaction->date = date('Y-m-d H:i:s');
            $transaction->summ = $text[2];
            $transaction->category = $text[1];
            $transaction->type = $text[0];
            if ($transaction->validate()) {
                $transaction->save();
            } else {
                $this->sendError($mail->fromAddress, 'You cannot spend expenditure transactions
                     for an amount higher than your account balance.');
                continue;
            }
        }
    }

    private function checkMailText($text, $mail)
    {
        if ($text[0] != 'debit' && $text[0] != 'deposit') {
            $this->sendError($mail->fromAddress, 'Incorrect type');
            return false;
        }

        $category = Category::find()
            ->where(['login' => $mail->subject])
            ->andWhere(['typeOfCategory' => $text[0]])
            ->all();
        $hasCategory = false;
        foreach ($category as $item) {
            if ($item->category == $text[1]) {
                $hasCategory = true;
            }
        }
        if (!$hasCategory) {
            $this->sendError($mail->fromAddress, 'Incorrect category');
            return false;
        }

        if (!is_numeric($text[2])) {
            $this->sendError($mail->fromAddress, 'Incorrect summ');
            return false;
        }
        return true;
    }

    private function checkSender($mail)
    {
        $user = User::find()
            ->where(['login' => $mail->subject])
            ->one();
        if ($user === null) {
            $this->sendError($mail->fromAddress, 'Incorrect login');
            return false;
        }

        if ($user->email != $mail->fromAddress) {
            $this->sendError($mail->fromAddress, 'Incorrect address');
            return false;
        }

        return true;
    }


    private function sendError($address, $message)
    {
        Yii::$app->mailer->compose()
            ->setFrom('sasintimur@yandex.ru')
            ->setTo($address)
            ->setSubject('error')
            ->setHtmlBody($message)
            ->send();
    }

    private function parseMailBody($body)
    {
        $body = str_replace(chr(10), '', $body);
        $body = explode(chr(13), $body);
        $body = array_diff($body, ['']);
        $body = array_values($body);
        return $body;
    }
}